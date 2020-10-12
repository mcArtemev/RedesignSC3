<?/*<input type="hidden" value="<?=$this->_datas['max_amount']?>" name="max_amount"/>*/?>
<script type="text/javascript">
$(function(){
    $(".amount").each(function(){
        amount = parseInt($(this).text());
        max_amount = parseInt($("[name=max_amount").val());
        str = '';
        for (i=0; i<max_amount; i++)
        {
            cl = 'amount-item';
            if (i < amount) cl += ' active';
            str += '<div class="' + cl + '"></div>'
        }
        $(this).html(str);
    });

    <? $accord = array('n' => 'laptop', 'p' => 'tablets', 'f' => 'phones'); ?>
    <?/*$(".aside-menu li a[href*=<?=$accord[$this->_suffics]?>]").addClass("active");*/?>

})
</script>
