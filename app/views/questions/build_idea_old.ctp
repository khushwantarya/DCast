<div id="popup">
  <div id="popupcontent">
    <div style="float: left; width: 300px;">
      <h1>Build On Idea</h1>
      <div id="ideadetails">
        <div style="padding: 0px 25px;">
          <div style="height: 83px; overflow: auto;"> <a style="font-size: 11px;" class="hyperlink2" href="#">this is for test</a> </div>
          <div style="height: 25px;">
            <div style="float: left; width: 25px;"> <?php echo $this->Html->image("icon-worst-thing.png", array("alt" => "")); ?> </div>
            <div class="submittedby" style="float: left;"> 
							<abbr title="12/6/2011 11:34:58 AM" class="timeago">4 days ago</abbr> 
							by <a class="colorbox submittedbyname" href="PublicProfile.aspx?UserId=2165">bioquimico</a> 
						</div>
            <div class="clear"></div>
          </div>
          <div style="height: 20px;">
            <div style="float: left; width: 115px;"> 
							<a onClick="submitIdeaAsFavorite(25588);">
								<?php echo $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")); ?>
							</a> Mark Favorite 
						</div>
            <div style="float: left; margin-top: -4px;">
              <table>
                <tbody>
                  <tr>
                    <td>
											<div>
												<a title="Outlier Award" onClick="awardCard(1, 2165, 25588);">
													<?php echo $this->Html->image("award-outlier-idea-off.png", array("alt" => "Outlier Award", "height" => 25)); ?>
												</a>
											</div>
										</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <div style="margin-left: -7px; margin-right: -17px; margin-top: 15px; height: 30px;"> 
				<a class="buttonsm agree buildon" onClick="buildPopup(7, 25588, this);">Agree</a> 
				<a class="buttonsm disagree" onClick="buildPopup(8, 25588, this);">Disagree</a> 
				<a class="buttonsm modify" onClick="buildPopup(9, 25588, this);">Modify</a> 
				<a class="buttonsm quest" onClick="buildPopup(10, 25588, this);">Question</a>
        <input type="hidden" value="7" id="cardtype">
      </div>
      <textarea maxlength="250" style="width: 100%; height: 40px;" rows="4" cols="35" id="comments" class="watermark"></textarea>
      <div class="status">250 character(s) left</div>
      <div style="text-align: right; margin-top: -10px;"> 
				<a onClick="submitBuildQuestionResponse(41, 25588);">
					<?php echo $this->Html->image("submit-orange.png", array("alt" => "Submit")); ?>
				</a> 
			</div>
      <h2 style="margin-top: 0px;">My Private Notes</h2>
      <textarea style="width: 100%; height: 40px;" rows="4" cols="35" id="notes" class="watermark"></textarea>
      <div class="status">500 character(s) left</div>
      <div style="text-align: right; margin-top: -10px;"> 
				<span id="notesresult"></span> 
				<a onClick="saveNotes(25588, $('#notes').val());">
					<?php echo $this->Html->image("save-orange.png", array("alt" => "Save")); ?>
				</a> 
			</div>
      <div style="position: relative; margin-top: 5px;">
        <input type="text" style="width: 240px; margin-right: 10px;" size="32" value="" class="tags watermark" id="tags">
        <span class="tagMatches"></span>
        <div style="position: absolute; right: 0px; top: 4px;"><a onClick="SaveTagsForIdeaBuild(25588);"><?php echo $this->Html->image("save-orange.png", array("alt" => "Save")); ?></a></div>
      </div>
    </div>
    <div style="float: right; width: 300px;">
      <h2 style="margin: 5px 0px 10px 0px;">Related Ideas</h2>
      <div style="height: 385px; margin: 10px 0 0 0;" class="box">
        <ul class="ideas" id="relatedideas">
          <div class="emptybox">This idea has no related ideas. Use the form to the left to build on this idea.</div>
        </ul>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
