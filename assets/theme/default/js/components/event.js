// Event
function eventGridHover(e,t,s,_,d,a,l,n,v,o,i,r,C,c)
{
    $("#event_grid_"+C+c).removeClass(e),
    $("#event_grid_"+C+c).addClass(t),
    $("#even_grid_title_"+C+c).removeClass(s),
    $("#even_grid_title_"+C+c).addClass(_),
    $("#short_desc_title_"+C+c).removeClass(d),
    $("#short_desc_title_"+C+c).addClass(a),
    $("#short_desc_text_"+C+c).removeClass(l),
    $("#short_desc_text_"+C+c).addClass(n),
    $("#event_date_"+C+c).removeClass(v),
    $("#event_date_"+C+c).addClass(o),
    $("#event_location_"+C+c).removeClass(i),
    $("#event_location_"+C+c).addClass(r)
}function eventGridHoverOut(e,t,s,_,d,a,l,n,v,o,i,r,C,c)
{
    $("#event_grid_"+C+c).removeClass(t),
    $("#event_grid_"+C+c).addClass(e),
    $("#even_grid_title_"+C+c).removeClass(_),
    $("#even_grid_title_"+C+c).addClass(s),
    $("#short_desc_title_"+C+c).removeClass(a),
    $("#short_desc_title_"+C+c).addClass(d),
    $("#short_desc_text_"+C+c).removeClass(n),
    $("#short_desc_text_"+C+c).addClass(l),
    $("#event_date_"+C+c).removeClass(o),
    $("#event_date_"+C+c).addClass(v),
    $("#event_location_"+C+c).removeClass(r),
    $("#event_location_"+C+c).addClass(i)
}
    function eventDetailHeadHover(t,e)
    {
     $("#event_detail_heading").removeClass(e),
      $("#event_detail_heading").addClass(t)
   
   }
   function eventDetailHeadHoverOut(e,t)
   {
       $("#event_detail_heading").removeClass(t),
       $("#event_detail_heading").addClass(e)
    }
    function eventDescTitleHover(e,t,s)
    {
        $('[id="desc_title_'+s+'"]').removeClass(e),
        $('[id="desc_title_'+s+'"]').addClass(t)
    }
    function eventDescTitleHoverOut(e,t,s)
    {
        $('[id="desc_title_'+s+'"]').removeClass(t),
        $('[id="desc_title_'+s+'"]').addClass(e)
    }
    function eventDescTextHover(e,t,s)
    {
        $("#desc_text_"+s).removeClass(e),
        $("#desc_text_"+s).addClass(t)
    }
    function eventDescTextHoverOut(e,t,s)
    {
        $("#desc_text_"+s).removeClass(t),
        $("#desc_text_"+s).addClass(e)
    }
    $(document).ready(function(){$("#event_tab").tabs({})});