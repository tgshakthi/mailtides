<div class="common-space">
	<div class="container">
		<input type="hidden" id="review_user_id" name="review_user_id" value="<?php echo $query_string;?>">
		<input type="hidden" id="review_base_url" value="<?php echo base_url();?>">
		<div class="txgidoc-review">
			<div class="patient-review-column">
				<h3>Reviews and Rating</h3>
				<a href="#modal1" class="modal-trigger"><i class="fas fa-pencil-alt"></i> Share Your Story</a>

				<div id="modal1" class="modal">
					<div class="modal-content">
						<a href="javascript:void(0);" class="modal-close review-entry-close"> <i class="fas fa-times"></i></a>
						<form action="<?php echo base_url()?>reviews_entry/insert_reviews_entry" class="review-tiz-form"
							method="post">
							<input type="hidden" id="review_user_id" name="review_user_id" value="<?php echo $query_string;?>">
		                    <input type="hidden" id="review_base_url" value="<?php echo base_url();?>">
							
							<input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">
							<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id;?>">
							<input type="hidden" name="page_url" id="page_url" value="<?php echo $page_url;?>">
							<h4>Digestive & Liver Disease Consultants,P.A.</h4>
							<ul class="row new-re">

								<li>

									<div class="name_review">
										<div>
											<label class="label-re">Name</label>
											<input type="text" placeholder="Name" id="review_name" name="review_name" required>
										</div>

										<div>
											<label class="label-re">Email</label>
											<input type="text" placeholder="Email" id="review_email" name="review_email" required>
										</div>
									</div>
								</li>

								<li>
									<div class="spacer_break">
										<fieldset class="review_rating_entry">
											<input type="radio" id="star5" name="rating" value="5" checked /><label
												class="full" for="star5" title="Awesome - 5 stars"></label>
											<input type="radio" id="star4" name="rating" value="4" /><label class="full"
												for="star4" title="Pretty good - 4 stars"></label>
											<input type="radio" id="star3" name="rating" value="3" /><label class="full"
												for="star3" title="Meh - 3 stars"></label>
											<input type="radio" id="star2" name="rating" value="2" /><label class="full"
												for="star2" title="Kinda bad - 2 stars"></label>
											<input type="radio" id="star1" name="rating" value="1" /><label class="full"
												for="star1" title="Sucks big time - 1 star"></label>
										</fieldset>

										<input type="hidden" name="ratings" id="rating_star" value="">

									</div>

								</li>
								<li>
									<label class="label-re">Comments</label>
									<textarea name="comments" required></textarea>
								</li>
								<li>
									
										<input type="submit" value="Post" class="re-post">
										<!-- <input type="submit" value="Cancle" class="close"> -->
                                        
                                        <div class="review-socialmedia">

								<a href="https://www.facebook.com/TxGIDocs/" class="facebook-review"><i
										class="fab fa-facebook-f"></i></a>
								<a href="https://www.google.com/search?q=Digestive+%26+Liver+Disease+Consultants%2C+P.A.&rlz=1C1CHBF_enUS841US841&oq=Digestive+%26+Liver+Disease+Consultants%2C+P.A.&aqs=chrome..69i57j35i39j0.654j0j8&sourceid=chrome&ie=UTF-8#lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1,,,"
									class="google-review"><i class="fab fa-google"></i></a>

							</div>
									
								</li>
							</ul>
							
						</form>
					</div>

				</div>

			</div>

			<?php 
				if(!empty($reviews_entries)):
				foreach($reviews_entries as $reviews_entry):
			?>
			<div class="patient-review-row">
				<div class=""> </div>
				<div class="patient-review-column">
					<div class="patient-review">
						<div class="review-post_name">
							<h5><?php echo $reviews_entry->name;?></h5>

							<!--<span><?php echo $reviews_entry->email;?></span>-->


						</div>

						<p class="customer-rating">
							<?php
										$checked5 = ($reviews_entry->rating == 5) ? "checked": "disabled";
										$checked4 = ($reviews_entry->rating == 4) ? "checked": "disabled";
										$checked3 = ($reviews_entry->rating == 3) ? "checked": "disabled";
										$checked2 = ($reviews_entry->rating == 2) ? "checked": "disabled";
										$checked1 = ($reviews_entry->rating == 1) ? "checked": "disabled";

										echo '<span><div class="viewrating">
													<input type="radio" '.$checked5.'/>
													<label class="full"></label>													
													<input type="radio" '.$checked4.'/>
													<label class="full"></label>													
													<input type="radio" '.$checked3.'/>
													<label class="full"></label>													
													<input type="radio" '.$checked2.'/>
													<label class="full"></label>													
													<input type="radio" '.$checked1.'/>
													<label class="full"></label>													
												</div></span>';
												?>
						</p>

						<br>
						<p class="patient-review-comment"> <?php echo $reviews_entry->review;?></p>
						<br>
						<?php if(!empty($reviews_entry->source)):?>
						<a href="<?php echo $reviews_entry->source_url;?>"
							class="new_link_review"><?php echo $reviews_entry->source;?></a>
					</div>
					<?php endif;?>
				</div>
			</div>

			<?php
				endforeach;
				endif;
			?>


		</div>
	</div>
	<!--Container-->
</div>
</div>
