<?php require_once("components/header.php");
if ($conMessage):
	require_once("backend/select_properties.php");
	require_once "backend/search_filter.php";
endif;
?>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate pb-5 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Properties <i class="ion-ios-arrow-forward"></i></span></p>
				<h1 class="mb-3 bread">Choose <br>Your Desired Home</h1>
				<form action="properties.php" method="GET" class="search-location mt-md-5">
					<div class="row justify-content-center">
						<div class="col-lg-10 align-items-end">
							<div class="form-group">
								<div class="form-field">
									<input type="text" class="form-control" name="search" placeholder="Search location">
									<button type="submit"><span class="ion-ios-search"></span></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<?php include "properties-listing.php" ?>
</section>

<?php include_once "components/footer.php" ?>