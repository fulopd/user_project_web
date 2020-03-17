$(document).ready(function () {
    $(".filter-icon").click(function () {

        $("#filter-box").toggle(150);        
        $(".filter-icon").toggleClass( "filter-icon-sec" );               
        /*console.log($("#filter-box").css('display'));
         if ($("#filter-box").css('display') === "none") {
         $("#filter-box").show(150);
         } else {
         $("#filter-box").hide(150);
         }*/
    });
    //$("#asd").val("yyyy-MM-dd", new Date());


});