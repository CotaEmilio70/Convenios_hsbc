$(document).ready(function(){
    // =======================
    // Manejo de calendario en fechas
    // =======================
    $('.datetimepicker').datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        language: "es",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    });
    
    // =======================
    // Iniciar funcion tooltip
    // =======================
    $('[data-toggle="tooltip"]').tooltip();

    // =================
    // Iniciar fancybox
    // =================
    $(".fancybox").fancybox();

    // ====================
    // Funcion del paginado
    // ====================
    $(".pagination li a").click(function(){
        if($(this).data("href") != ""){
            if($("#Page").val() != $(this).data("href")){
                $("#Page").val($(this).data("href"));
                $("form:first").submit();
            }

        }
    })

    // ====================================
    // Funcion para avisar de campos vacios
    // ====================================
    $(".required-field").blur(function(){
        if($(this).val() != ""){
            $(this).parent().removeClass("has-error");
            $(this).next().hide();
        }
        if($(this).val() == "" && $("#hdTriedSave").val() == "true"){
            $(this).parent().addClass("has-error");
            $(this).next().show();
        }
    })

    $("[max-length]").keypress(function()
    {
        //event.preventDefault();
        var vMaxLength = $(this).attr("max-length");
        var vSelectedText = document.getSelection().toString();
        if($(this).val().length >= vMaxLength && vSelectedText.length == 0)
        {
            return false;
        }
    })

    $(".fill").change(function()
    {
        if($(this).val().length > 0)
        {
            var vMaxLength = $(this).attr("max-length");
            if($(this).val().length < vMaxLength)
            {
                var vValue = $(this).val();
                var vNumberCeros = vMaxLength - $(this).val().length;
                var vCeros = "";
                for(var i = 0; i < vNumberCeros; i++)
                {
                    vCeros += "0";
                }
                $(this).val(vCeros + vValue);
            }
        }
    })

    // ==============================
    // Funcion para campos numericos
    // ==============================
    $(".numeric-fiedl").keypress(function(event){
        if($(this).val() == "" && event.charCode == 46){
            return false;
        }
        if($(this).val().split('.').length >= 2 && event.charCode == 46 ){
            return false;
        }
        return event.charCode >= 48 && event.charCode <=57 || event.charCode == 46 || event.charCode == 13;
    })

    // ===================
    // Just number funcion
    // ===================
    $(".just-number").keypress(function(event){
        return event.charCode >= 48 && event.charCode <=57 || event.charCode == 13;
    })

    // ===================
    // Delete function
    // ===================
    $("[data-message-delete]").click(function()
    {
        var vMessage = $(this).attr("data-message-delete");
        bootbox.confirm({
            message: vMessage,
            callback: function(result)
            {
                var vHasForm = $("#frmDelete").attr("id") != undefined? true : false;
                if(result)
                {
                    if(vHasForm)
                    {
                        $(".loader-gif").show();
                        $("#frmDelete").submit();
                    }
                    else
                    {
                        bootbox.alert("Ocurrio un error, contacte al administrador.");
                    }
                }
            }
        }); 
    })
})

// ====================================
// Funcion para avisar de campos vacios
// ====================================
function RequiredField(vElement)
{
     if($(vElement).val() != ""){
            $(vElement).parent().removeClass("has-error");
            $(vElement).next().hide();
        }
        if($(vElement).val() == "" && $("#hdTriedSave").val() == "true"){
            $(vElement).parent().addClass("has-error");
            $(vElement).next().show();
        }
}
