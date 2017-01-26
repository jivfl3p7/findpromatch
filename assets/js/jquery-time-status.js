jQuery(document).ready(function() {
    var date = jQuery('#dateplace');
    var time = jQuery('#timeplace');
  
    function updateTime() {
        var now = new Date();

        var nowdate = now.toString('d MMMM yyyy');
        var nowtime = now.toString('HH : mm : ss');

        date.text(nowdate);        
        time.text(nowtime);        
    }
  
    updateTime();
    setInterval(updateTime, 100); // 100 miliseconds
});
