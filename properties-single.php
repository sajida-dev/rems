<?php include_once("components/header.php") ?>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate pb-5 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Properties <i class="ion-ios-arrow-forward"></i></span></p>
				<h1 class="mb-3 bread">Properties Single</h1>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-property-details">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="property-details">
					<div class="img" style="background-image: url(images/work-1.jpg);"></div>
					<div class="text text-center">
						<span class="subheading">Oakland</span>
						<h2>The Blue Sky Home</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 pills">
				<div class="bd-example bd-example-tabs">
					<div class="d-flex justify-content-center">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Features</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-manufacturer-tab" data-toggle="pill" href="#pills-manufacturer" role="tab" aria-controls="pills-manufacturer" aria-expanded="true">Description</a>
							</li>
						</ul>
					</div>

					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
							<div class="row">
								<div class="col-md-4">
									<ul class="features">
										<li class="check"><span class="ion-ios-checkmark"></span>Lot Area: 1,250 SQ FT</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Bed Rooms: 4</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Bath Rooms: 4</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Luggage</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Garage: 2</li>
									</ul>
								</div>
								<div class="col-md-4">
									<ul class="features">
										<li class="check"><span class="ion-ios-checkmark"></span>Floor Area: 1,300 SQ FT</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Year Build:: 2019</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Water</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Stories: 2</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Roofing: New</li>
									</ul>
								</div>
								<div class="col-md-4">
									<ul class="features">
										<li class="check"><span class="ion-ios-checkmark"></span>Floor Area: 1,300 SQ FT</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Year Build:: 2019</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Water</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Stories: 2</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Roofing: New</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
							<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
							<p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once "components/footer.php" ?>

<script>
	$(document).ready(function() {
		$('#pills-tab a').on('click', function(e) {
			e.preventDefault();
			var hash = this.hash;
			$(this).tab('show');

			if (history.pushState) {
				history.pushState(null, null, hash);
			} else {
				window.location.hash = hash;
			}
		});
	});
</script>