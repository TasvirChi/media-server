package com.kaltura.media.quality.validator;

import java.io.File;
import java.util.List;

import org.apache.log4j.Logger;

import com.kaltura.media.quality.comparators.imagemagik.ImageMagikComparator;
import com.kaltura.media.quality.configurations.DataValidator;
import com.kaltura.media.quality.event.Event;
import com.kaltura.media.quality.event.EventsManager;
import com.kaltura.media.quality.event.SegmentErrorEvent;
import com.kaltura.media.quality.event.listener.IListener;
import com.kaltura.media.quality.event.listener.ISegmentFirstFrameImageListener;
import com.kaltura.media.quality.event.listener.ISegmentsListener;
import com.kaltura.media.quality.event.listener.ISegmentsResultsListener;
import com.kaltura.media.quality.model.Segment;
import com.kaltura.media.quality.utils.ImageUtils;
import com.kaltura.media.quality.utils.ThreadManager;

/**
 * Compares between segments from different renditions by comparing the first frame 
 */
public class RenditionsComparator extends Validator implements ISegmentsListener {
	private static final long serialVersionUID = -8200877988082291537L;
	private static final Logger log = Logger.getLogger(RenditionsComparator.class);
	
	private String uniqueId;
	private boolean deffered;

	class SegmentsResultsEvent extends Event<ISegmentsResultsListener>{
		private static final long serialVersionUID = -8330040440848338116L;
		private Segment segment1;
		private Segment segment2;
		private double diff;

		public SegmentsResultsEvent(Segment segment1, Segment segment2, double diff) {
			super(ISegmentsResultsListener.class);
			
			this.segment1 = segment1;
			this.segment2 = segment2;
			this.diff = diff;
		}

		@Override
		protected void callListener(ISegmentsResultsListener listener) {
			listener.onSegmentsResult(segment1, segment2, diff);
		}

		@Override
		protected String getTitle() {
			String title = segment1.getEntryId();
			title += "-" + segment1.getRendition().getDomainHash();
			title += "-" + segment1.getRendition().getBandwidth();
			title += "-" + segment1.getNumber();
			title += "-" + segment2.getNumber();
			return title;
		}
		
	}
	
	class ValidationTask implements Runnable{

		private List<Segment> segments;
		
		public ValidationTask(List<Segment> segments) {
			this.segments = segments;
		}

		@Override
		public void run() {
			handleSegments(segments);
		}
	}

	class SegmentFirstFrameImageEvent extends Event<ISegmentFirstFrameImageListener> {
		private static final long serialVersionUID = -1970944510668478236L;
		private Segment segment;
		private File frame;
	
		public SegmentFirstFrameImageEvent(Segment segment, File frame) {
			super(ISegmentFirstFrameImageListener.class);
			
			this.segment = segment;
			this.frame = frame;
		}

		@Override
		protected void callListener(ISegmentFirstFrameImageListener listener) {
			listener.onSegmentFirstFrameCapture(segment, frame);
		}
	
		@Override
		protected String getTitle() {
			String title = segment.getEntryId();
			title += "-" + segment.getRendition().getDomainHash();
			title += "-" + segment.getRendition().getBandwidth();
			title += "-" + segment.getNumber();
			return title;
		}
	
	}


	public RenditionsComparator() {
		super();
	}
	
	public RenditionsComparator(String uniqueId, DataValidator dataValidator) {
		this();
		
		this.uniqueId = uniqueId;
		this.deffered = dataValidator.getDeffered();
		
		register();
	}

	@Override
	public void register() {
		EventsManager.get().addListener(ISegmentsListener.class, this);
	}
	
	private File getFirstFrameFromFile(Segment segment) throws Exception {
		File ts = segment.getFile();
		File dest = new File(ts.getAbsolutePath() + ".jpeg");
		if(!dest.exists()){
			//	save first frame to file
			ImageUtils.saveFirstFrame(ts, dest);
			EventsManager.get().raiseEvent(new SegmentFirstFrameImageEvent(segment, dest));
		}
		
		return dest;
	}

	@Override
	public void onSegmentsDownloadComplete(List<Segment> segments) {
		if(!segments.get(0).getEntryId().equals(uniqueId)){
			return;
		}

		if(!isDeffered() && !EventsManager.isConsumingDefferedEvents()){
			ThreadManager.start(new ValidationTask(segments));
			return;
		}
		
		handleSegments(segments);
	}
	
	protected void handleSegments(List<Segment> segments){
		Segment segment1 = segments.get(0);
		File file1 = segment1.getFile();
		File file2;

		Thread thread = Thread.currentThread();
		thread.setPriority(Thread.MIN_PRIORITY);
		thread.setName(getClass().getSimpleName() + "-" + file1.getAbsolutePath());
		
		File image1;
		try {
			image1 = getFirstFrameFromFile(segment1);
		} catch (Exception e) {
			log.error(e.getMessage(), e);
			EventsManager.get().raiseEvent(new SegmentErrorEvent(segment1, e));
			return;
		}
		File image2;

		String outputFolder = file1.getParent();
		String outputName;
		String diffPath;
		double diff;
		
		// Check 1-2, 2-3, 3-4, ...
		for(int i = 1 ; i < segments.size(); ++i) {
			
			if(!ThreadManager.shouldContinue()){
				break;
			}
			
			Segment segment2 = segments.get(i);
			file2 = segment2.getFile();
			try {
				image2 = getFirstFrameFromFile(segment2);
			} catch (Exception e) {
				log.error(e.getMessage(), e);
				EventsManager.get().raiseEvent(new SegmentErrorEvent(segment2, e));
				continue;
			}
			outputName = file2.getParentFile().getParentFile().getName();
			diffPath = outputFolder + "/diff_" + segment1.getNumber() + "_" + outputName + ".jpg";
			
			log.info("Comparison of entry [" + uniqueId + "]" + file1 + " and " + file2);
			ImageMagikComparator imComparator = new ImageMagikComparator(diffPath);
			diff = imComparator.compare(image1, image2);
			EventsManager.get().raiseEvent(new SegmentsResultsEvent(segment1, segment2, diff));
			
			file1 = file2;
			image1 = image2;
		}
	}

	@Override
	public int compareTo(IListener o) {
		if(o == this){
			return 0;
		}
		return 1;
	}

	@Override
	public boolean isDeffered() {
		return deffered;
	}

	@Override
	public String getTitle() {
		return uniqueId;
	}
}