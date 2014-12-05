$(function(){
    $('#parent_id').autocomplete({
        source: "parent",
        select: function(event, ui){
            $('#to_parent_id').val(ui.item.id);
        }
    });
});
$(function(){
    $('#sponsor_id').autocomplete({
        source: "sponsor",
        select: function(event, ui){
            $('#to_sponsor_id').val(ui.item.id);
        }
    });
});
