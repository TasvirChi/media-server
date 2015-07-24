package tasks;

import org.apache.commons.io.FileUtils;
import org.apache.commons.io.filefilter.IOFileFilter;
import org.apache.commons.io.filefilter.SuffixFileFilter;
import org.apache.log4j.Logger;
import utils.ProcessHandler;

import java.io.*;
import java.util.*;
import java.util.concurrent.TimeUnit;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * Created by AsherS on 7/23/15.
 */
public class PtsComparator {

    private static final Logger log = Logger.getLogger(PtsComparator.class);
    private static final double MAX_PTS_DIFF = 50d;

    private static String pathToFfprobe;

    private static double ptsReader(File fin) throws Exception {

        //search for pkt_pts=299.955378

        BufferedReader br = null;
        try {
            br = new BufferedReader(new FileReader(fin));

            String line;
            while ((line = br.readLine()) != null) {
                if (line.startsWith("pkt_pts")) {
                    String[] l = line.split("=");
                    if (l.length != 2) {
                        throw new Exception("file: " + fin.getAbsolutePath() + " pkt_dts_time does not contain 2 values");
                    }
                   return Double.valueOf(l[1].trim());
                }
            }
        }  finally {
            if (br != null) {
                br.close();
            }
        }

        throw new Exception("file: " + fin.getAbsolutePath() + " PTS not found");
    }

    private static String generateRandomSuffix() {
        return String.valueOf(System.currentTimeMillis());
    }

    private static double extractPts(File videoFile) throws Exception {

        String destination = "/tmp/" + generateRandomSuffix();
//        String script = buildFirstFrameCommand(videoFile.toString(), destination);
        ProcessBuilder pb = ProcessHandler.createProcess(buildFirstFrameCommand(videoFile.toString(), destination));
        Process p = ProcessHandler.start(pb);
        ProcessHandler.waitFor(p, 10, TimeUnit.SECONDS);

        //delete script
        //read destination file and extract pts of first frame
        File destFile = new File(destination);
        try {
            double pts = ptsReader(destFile);
            return pts;
        } finally {
            try {
                //delete temp file
                FileUtils.forceDelete(destFile);

                //todo additional try
//                FileUtils.forceDelete(new File(script));
            } catch (IOException e) {
                log.error("failed to delete dest file: " + destination);
            }
        }
    }

    private static void writeToFile(String name, String content) throws IOException {
        Writer writer = null;

        try {
            writer = new BufferedWriter(new OutputStreamWriter(
                    new FileOutputStream(name), "utf-8"));
            writer.write(content);
        } finally {
            try {writer.close();} catch (Exception ex) {/*ignore*/}
        }
    }

    private static String[] buildFirstFrameCommand(String videoFile, String destination) throws IOException {
        //ffprobe file.ts -show_frames > destination
//        String script = "/tmp/script_" + generateRandomSuffix() + ".sh";
        String command = pathToFfprobe + " " + videoFile + " -show_frames > " + destination;
//        writeToFile(script, command);
//        return script;
        return new String[]{"bash", "-c", command};
    }


    private static Integer extractTsNumber(String tsName) {
        Pattern pattern = Pattern.compile("\\D(\\d+)\\.ts");
        Matcher matcher = pattern.matcher(tsName);
        if (matcher.find()) {
            return Integer.valueOf(matcher.group(1));
        }
        return null;
    }

    private static List<File> getSortedFilesList(Collection<File> files) {
        List<File> newList = new ArrayList<>(files);
        Collections.sort(newList, new Comparator<File>() {
            @Override
            public int compare(File o1, File o2) {
                Integer num1 = extractTsNumber(o1.getName());
                Integer num2 = extractTsNumber(o2.getName());
                //TODO, NullPointerException
                return num1.compareTo(num2);
            }
        });
        return newList;
    }

    public static void comparePts(List<File> sortedFiles) {
        if (sortedFiles.size() == 0) {
            log.error("Sorted list is empty");
            return;
        }

        int i=0;
        int firstIndex = extractTsNumber(sortedFiles.get(i).toString());

        while (i < sortedFiles.size() - 1) {

            int secondIndex = extractTsNumber(sortedFiles.get(i + 1).toString());

            if (firstIndex == secondIndex) {
                log.debug("comparing: " + sortedFiles.get(i).toString() + " and " + sortedFiles.get(i + 1).toString());
                compareFilesPts(sortedFiles.get(i), sortedFiles.get(i + 1));
            }

            firstIndex = secondIndex;
            i++;
        }
    }

    private static void compareFilesPts(File file1, File file2) {
        try {
            double pts1 = extractPts(file1);
            double pts2 = extractPts(file2);

            double diff = Math.abs(pts1 - pts2);
            log.debug("file1: " + file1.getAbsolutePath() + " pts: " + pts1 + "\nfile2: " + file2.getAbsolutePath() + " pts: " + pts2 + "\ndiff: " + diff);

            if ( (diff/90000d) > MAX_PTS_DIFF) {
                log.error("ts are with different PTS");
            }
        } catch (Exception e) {
            log.error("failed to get PTS from " + file1.getAbsolutePath() + " or " + file2.getAbsolutePath(),e);
        }
    }

    public static void comparePtsDir(File dir) {

        IOFileFilter filter = new IOFileFilter() {
            @Override
            public boolean accept(File file) {
                return !file.getName().contains("DVR");
            }

            @Override
            public boolean accept(File dir, String name) {
                return !name.contains("DVR");
            }
        };
        //filter DVR out
        Collection<File> sourceOnly = FileUtils.listFiles(dir, new SuffixFileFilter("ts"), filter);
        List<File> sortedList = getSortedFilesList(sourceOnly);

        log.info("about to compare files from: " + dir.getAbsolutePath() + ". num files: " + sortedList.size());
        comparePts(sortedList);
        log.info("===========================================================");
    }
    public static void main(String[] args) {

        String storageDir = args[0];
        pathToFfprobe = args[1];
        String allFiles = args[2];

        log.info("storage dir: " + storageDir);
        log.info("path to ffprobe: " + pathToFfprobe);

        if (allFiles.equals("false")) {
            comparePtsDir(new File(storageDir));
            return;
        }

        log.info("getting files from folder: " + storageDir);
        List<File> files = new ArrayList<>();
        listDirectories(new File(storageDir), files);
        log.info("finished to list directories: " + files.size());
        for (File f : files) {
            comparePtsDir(f);
        }
    }

    public static void listDirectories(File dir, List<File> list) {

        File[] files = dir.listFiles();
        for (File file : files) {
            if (file.getName().startsWith("flavor") || file.getName().startsWith("iter") || file.getName().startsWith("diff") || file.getName().startsWith("chunklist")) {
                continue;
            }
            if (file.isDirectory()) {
                if (file.getName().startsWith("2015_07")) {
                    list.add(file);
                }
                listDirectories(file, list);
            }
        }
    }
}
