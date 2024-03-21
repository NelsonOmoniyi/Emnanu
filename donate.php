<?php include("assets/inc/header.php") ?>


  <main id="main">
   <!-- ======= Hero Section ======= -->
   <section id="hero7" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative text-center" data-aos="zoom-in" data-aos-delay="100">
      <h1>Donate Now</h1>
      <br>
      <h5>We believe that energized people, working well together, fueled by great leadership, in an environment in which they thrive, will do phenomenal things. </h5>
    </div>
  </section><!-- End Hero -->

  <section>
    <div class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-md-center">
            <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                <form id="form1" onsubmit="return false">
                    <input type="hidden" name="op" value="Payment.process_payment">
                    <div class="row gy-3 gy-md-4 overflow-hidden">
                    <div class="col-12">
                        <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="mobile" name="mobile" maxlength="13" required>
                    </div>
                    <div class="col-12">
                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="amount" id="amount" required>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                        <div id="server_mssg"></div>
                        <button id="button" class="btn btn-primary mb-1">Donate</button>
                        </div>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
  </section>

  </main><!-- End #main -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="server/js/jquery.blockUI.js"></script>
<script src="server/js/parsely.js"></script>
<script src="server/js/sweet_alerts.js"></script>
<script src="server/js/main.js"></script>
<script>
	$("#button").click(function(){
        var id = 'form1'
        var forms = $('#' + id);
		forms.parsley().validate();
		if (forms.parsley().isValid()) {
			$.blockUI();
			var data = $("#" + id).serialize();
            // console.log(data);
            // return;
			$.post("server/utilities.php", data, function(res) {
				$.unblockUI();
                // console.log(res);
                // alert(res)
				var response = JSON.parse(res);
				// alert(response.redirect)
                var redirect = response.redirect;
                var rescode = response.response_code;
                var resmessage = response.response_message;

				if (rescode == 200) {
                    
                    swal({
                        text: resmessage,
                        icon: "success",
                    });
                    $("#button").attr("disabled", true);
                    
					setTimeout(() => {
						window.location = redirect;
					}, 1000);
				} else {
                    $("#button").attr("enabled", true);
					$("#server_mssg").html(response.response_message);
				}
			});
		}
    });

	window.onbeforeunload = function() {
		return 'You cannot leave this page';
	}
</script>
  <?php include("assets/inc/footer.php") ?>