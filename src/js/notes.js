/**
 * Created by Ark on 23.06.2017.
 */
$('select[name=type]').click(function(){
    var noteType = $('select[name=type]').val();
    if (noteType == 'Paragraph') {
        $('input[name=content]').hide();
        $('textarea[name=paragraphContent]').show();
    }else {
        $('input[name=content]').show();
        $('textarea[name=paragraphContent]').hide();
    }
});

$('li').click(function(){
    document.execCommand("copy");
    console.log($(this).text());
});