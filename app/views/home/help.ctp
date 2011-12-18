<h1><?php echo __("Help/Feedback", true); ?></h1>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">View Tutorial</a></li>
		<li><a href="#tabs-2">Questions/Feedback</a></li>
		<li><a href="#tabs-3">FAQ</a></li>
		<li><a href="#tabs-4">Scoring Rules</a></li>
	</ul>
	<div id="tabs-1">
		<div class="box">
			<div id="helptutorial">
				<div style="float: left; width: 395px; height: 330px; text-align: center;">
					<div style="margin-bottom: 15px; margin-top: 25px;"> Video Tutorial </div>
					<object height="237" width="372" style="margin: 0px;">
						<param value="http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=discoverycasttutorial-april222010-100422194834-phpapp02&amp;stripped_title=discoverycast-sage-tutorial-april-22-2010" name="movie">
						<param value="true" name="allowFullScreen">
						<param value="always" name="allowScriptAccess">
						<embed height="236" width="371" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=discoverycasttutorial-april222010-100422194834-phpapp02&amp;stripped_title=discoverycast-sage-tutorial-april-22-2010">
					</object>
				</div>
				<div style="float: right; width: 225px;">
					<div style="text-align: center; margin-top: 25px;"> Process Summary </div>
					<div style="padding: 15px; color: rgb(255, 255, 255);"> 
						Please view the presentation to the left in FULL SCREEN mode by  clicking the "menu" icon below the slides. 
						You can exit full screen mode by hitting the Esc key on your keyboard.<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						Additional Info:<br />
						<a target="_blank" style="color: rgb(196, 218, 159);" href="<?php echo Router::url("/uploads/files/pdf/"); ?>quicktips-discoverycast.pdf">DiscoveryCast QuickTips</a>&nbsp;<span class="highlight">(pdf)</span><br />
					</div>
				</div>
				<div class="clear"></div>
				<div style="text-align: center;">&nbsp;</div>
				<div style="margin-top: 15px;">
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="tabs-2">
		<div class="box">
			<div class="innerbox">
				<h2>Send Us Your Questions or Input</h2>
				<div>
					<form action="/" name="contactForm" id="contactForm">
						<div>
							<input type="radio" value="question" id="question" name="contact_type">
							Question &ndash; Submit your question about this ideation event<br />
						</div>
						<div>
							<input type="radio" value="suggestion" id="suggestion" name="contact_type">
							Suggestion &ndash; Submit your suggestions to improve the process <br />
						</div>
						<div>
							<input type="radio" value="feedback" id="feedback" name="contact_type">
							Feedback &ndash; Tell us what you like or do not like </div>
						<div>
							<input type="radio" value="contact" id="contact" name="contact_type">
							Learn more &ndash; Ask us how your organization can use DiscoveryCast </div>
						<div>
							<input type="radio" value="other" id="other" name="contact_type">
							Other </div>
					</div>
					<br />
					Please enter any questions or comments you have:<br />
					<br />
					<textarea style="width: 100%;" rows="4" cols="63" id="comments" name="comments"></textarea>
					<br />
					<br />
					<div style="text-align: right;"> <a id="send_contact"><?php echo $this->Html->image("submit-orange.png", array("alt" => "Submit")); ?></a> </div>
				</form>
			</div>
		</div>
	</div>
	<div id="tabs-3">
		<div class="box">
			<div class="innerbox">
				<h2>Fequently Asked Questions</h2>
				<center>
					(Don't see your relevant FAQ below? Contact us at <a href="mailto:support@discoverycast.com">support@discoverycast.com</a>)
				</center>
				<br />
				<div> <b>What is DiscoveryCast?&nbsp;</b><br />
					<br />
					DiscoveryCast is a service for groups of individuals to gather together online in a virtual ideation environment. The process starts with the development of a scenario, challenge, or series of questions that is focused on a specific subject. Once the scenario has been selected it is shared with an invited group of participants. Each ideation session has a specific start and end time and typically will last from 2-3 days. Once the event is completed, DiscoveryCast provides a summary of the results including, top ideas, top participants, major themes, and new insights gathered from the ideation session.<br />
					<br />
					<b>Do I need anything special to use it?</b><br />
					<br />
					All you need to participate is an Internet connection and a valid email account. We use your email account to authenticate you as a participant and to send you updates during the event. To join the event all you need is a <u>current</u> Internet browser program such as <a href="http://en.wikipedia.org/wiki/Internet_Explorer_7" target="_blank">Internet Explorer</a>, <a href="http://www.mozilla.com/en-US/firefox/personal.html" target="_blank">Firefox</a>, or <a href="http://www.apple.com/safari/" target="_blank">Safari</a>. &nbsp;In order to look at our super cool visualizations of the ideas, you also need <a href="http://silverlight.net/" target="_blank">Microsoft Silverlight</a> installed on your computer.<br />
					<br />
					<b>The layout on my screen looks funny. Is there something I can do to fix this? </b><br />
					<br />
					You can start by hitting the "Refresh" button on your browser to make sure the page loaded properly. In order to get the most out of the event, you should be using a current internet browser such as Internet Explorer version 7.0 or higher, Firefox version 3.0 or higher and Safari Version 4.0 or higher. <br />
					<br />
					<b>Can anyone join an event (randomly)?</b><br />
					<br />
					No. All participants are pre-selected and authenticated prior to participating in any on-line ideation event.<br />
					<br />
					<b>Does DiscoveryCast do anything with my personal data?</b><br />
					<br />
					Not at all. DiscoveryCast does not sell, share, or publicize in any way your personal information. We may, however, contact you in the future to share results from the ideation event you participated in and to invite you to future events.<br />
					<br />
					<b>I can't see the video for the scenario? What are my options?</b><br />
					<br />
					We have tested (and re-tested!!) our platform to be compatible with most current Internet browsers. There may be instances where your employer (or possibly your internet service provider) might intentionally or inadvertently block video. To acquaint you with the scenario we have also provided documentation in the Summary Section of the VIEW Challenge page. &nbsp;Here you can download related files that describe the scenario.<br />
					<br />
					<b>Why must I select a UserID and not just use my real name?</b><br />
					<br />
					In order to provide as open and unbiased an event as possible, we do not allow people to use their real names. This gives every idea an equal opportunity to stand out, and every idea is judged by it's own merits and not by who submitted it.<br />
					<br />
					<b>I joined the ideation event after it started, how do I get acquainted with what has happened so far?</b><br />
					<br />
					The best way to learn what is happening in the ideation event is to go to the "SEE Ideas" tab and look at the Leaderboard, Word Clouds, and Idea Maps. This gives you a birds-eye view of what has been shared thus far in the event. Be sure to use the Search feature as well.<br />
					<br />
					<b>What's the best way to participate? Share my original ideas or build on existing ideas?</b><br />
					<br />
					Any idea is valuable, therefore we encourage you to participate in any way you choose. Some people are good at originating ideas while others are better at reacting and building on existing ideas.<br />
					<br />
					<b>If another participant asks me a question, where can I read/answer it?</b><br />
					<br />
					On your profile page you can see any question(s) for you. These questions occur based on ideas that you already submitted. If you click on any question you will be taken to a screen that allows you to enter your response. <br />
					<br />
					<b>Why do you limit my ideas to just 250 characters?</b><br />
					<br />
					By limiting the length of the post we can make it easy for people to share ideas, since we're not asking for a full-length blog post. Also the short field requires you to break up your idea into smaller, more discrete elements. And finally, we hope this will give everyone the ability to contribute multiple ideas.<br />
					<br />
					<b>I still have a question that I need answered. How do I contact DiscoveryCast?</b><br />
					<br />
					For any further questions please contact us at <a href="mailto:support@discoverycast.com" target="_blank">support@discoverycast.com</a> or click on the Help/Feedback link in the left Margin and click the Questions/Feedback tab to submit your ideas.<br />

				</div>
			</div>
		</div>
	</div>
	<div id="tabs-4">
		<div class="box">
			<div class="innerbox">
				<h2>Scoring Rules</h2>
				<div style="float: left;">
					<table cellspacing="3" cellpadding="3" border="0">
						<tbody>
							<tr>
								<td><b>POINTS</b></td>
								<td><b>ACTION</b></td>
							</tr>
							<tr>
								<td style="text-align: center;">50</td>
								<td>Your idea gets favorited</td>
							</tr>
							<tr>
								<td style="text-align: center;">50</td>
								<td>Someone builds on your idea</td>
							</tr>
							<tr>
								<td style="text-align: center;">50</td>
								<td>You select an avatar</td>
							</tr>
							<tr>
								<td style="text-align: center;">50</td>
								<td>You select a unique anonymous UserID</td>
							</tr>
							<tr>
								<td style="text-align: center;">100</td>
								<td>You post an idea (any idea type)</td>
							</tr>
							<tr>
								<td style="text-align: center;">100</td>
								<td>You're the grandparent of a top idea or BIG idea</td>
							</tr>
							<tr>
								<td style="text-align: center;">250</td>
								<td>You're the parent of a top idea or BIG idea</td>
							</tr>
							<tr>
								<td style="text-align: center;">1000</td>
								<td>Your idea is marked as "BIG" by a moderator</td>
							</tr>
							<tr>
								<td style="text-align: center;">1000</td>
								<td>Your idea is marked favorite 20 times by others (Top Idea)</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div style="float: left;">
					<table cellspacing="3" cellpadding="3" border="0">
						<tbody>
							<tr>
								<td colspan="2"><b>LEVEL AWARDS</b></td>
							</tr>
							<tr>
								<td style="text-align: right;">100-500</td>
								<td>NOVICE</td>
							</tr>
							<tr>
								<td style="text-align: right;">500-1500</td>
								<td>PRO</td>
							</tr>
							<tr>
								<td style="text-align: right;">1500-3500</td>
								<td>EXPERT</td>
							</tr>
							<tr>
								<td style="text-align: right;">&gt;3500</td>
								<td>GENIUS</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="clear"></div>
				<br />
				<!--<b>EARNED AWARDS</b><br />
				<br />
				 * Moderators do not designate Top Ideas, they only designate BIG Ideas.<br />
				* To reach Top Idea, your idea needs to accumulate 1000 points by being marked favorite by others.  -->
				
			</div>
		</div>
	</div>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function (){
	$("#tabs").tabs({ cookie: { expires: 30 } });
	
	$("#send_contact").click(function() {

		if($("input:radio[name=contact_type]:checked").val() == undefined)
		{
			alert("Please select your Contact type category from the radio buttons.");
			$("input:radio[name=contact_type]:first").focus();
			return false;
		}
		if($("#comments").val() == "")
		{
			alert("Please enter your comments to send to the admin.");
			$("#comments").focus();
			return false;
		}
		
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "home","action" => "send_contact_email")); ?>",
			data: "contact_type=" + $("input:radio[name=contact_type]:checked").val() + "&comments=" + $("#comments").val(),
			success: function(data){
				//alert(data);
				if(data == 1)
				{
					var checked_radio_id = $("input:radio[name=contact_type]:checked").attr("id");
					alert("Your detail has beed submitted successfully, We will contact you soon.");
					//$("#contactForm").reset();
					//reset the  form 
					$("#" + checked_radio_id).attr("checked", false);
					$("#comments").val("");
				}
			}
		});
		
	});
	
});
</script>