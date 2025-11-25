<div class="row">
	<?php if($this->session->flashdata('logged-message')){?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php echo $this->session->flashdata('logged-message'); ?>
        </div>
    <?php } ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h3>Bienvenido <?=$this->session->Name ?>!</h3>
    </div>
</div>


<button id="log" class="btn btn-xs btn-success" style="display: none;">Abrir login</button>
<div class="row col-md-12" id="login">
	
</div>

<script type="text/javascript">
	$(function()
	{
		$("#log").click(function()
		{
			$.ajax({
                url: $("#url").val() + '/Users/GetLogin/',
                dataType: "html",
                data: {
                    
                },
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#login").html(data);
                },
                error: function (error) {
                    bootbox.alert(error.responseText);
                }
            });
		})
	})
</script>