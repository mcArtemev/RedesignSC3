path_post_ajax = "/ajax/";
ajax_loading = false;
var timeout = {};

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone(phone) {
    return phone.match(/\d/g).length===11;
}

function strong(text)
{
    return '<strong>' + text + '</strong>';
}

function form_err_str(error)
{
    if(error.length>0)
    {
        if(error.length == 1)
        {
            error_str = "Поле ";
            ed = " обязательно ";
        }
        else
        {
            error_str = "Поля ";
            ed = " обязательны ";
        }
        
        error_str += error.join(", ")  + ed + "для заполнения.";
    }
    else
        error_str = "";  
        
    return error_str;      
}

function get_mas($context, args_val)
{
     op_val = $context.data("op");
     func = op_val + "_args";     
     if (!window[func]) func = "fill_mas";            
     args_val = args_val || window[func]([$context]);
     
     return {op: op_val, args: args_val};
}

function color_table_args(func_param)
{
     mas = {};
     $context = func_param[0];
     $page = $context.find(".pagination a.active");
     if ($page.length>0)
        mas["page"] = $page.data("number");
        
     mas["table"] = $context.find("input[name=table]").val();
     return mas;
}     

function refresh_context($context, args_val)
{
     doPostAjax(get_mas($context, args_val), "get", [$context]); 
}

function fill_mas(func_param)
{
    mas = {};
    $context = func_param[0];
    $context.find("input[type=text][name], input[type=password][name], select[name], input[type=hidden], textarea[name]").each(function(){
        disabled = $(this).attr("disabled");
        if (!disabled && ($(this).closest(".wrapper").attr("id") == $context.attr("id")))
            mas[$(this).attr("name")] = $(this).val().trim();
    }); 
    
    $context.find("input[type=checkbox][name]:checked").each(function(){
        disabled = $(this).attr("disabled");
        if (!disabled && ($(this).closest(".wrapper").attr("id") == $context.attr("id")))
            mas[$(this).attr("name")] = $(this).val().trim();
    }); 
    return mas;
}

function change_screen(code, answer)
{
    if (code == "success")
    {
        $("body").html(answer);   
    }
}

function doPostAjax(param, func, func_param)
{
    param = param || {};
    func = func || "noop";
    func_param = func_param || [];
    
    if (!ajax_loading)
    {
        ajax_loading = true;
        console.log(param);
        $.post(path_post_ajax, param, function(data){
            //console.log(data);
            ajax_loading = false;  
            window[func](data["code"], data["answer"], func_param);            
            
        }, 'json');
    }
    else
    {
        setTimeout(function(){
                doPostAjax(param, func, func_param)
        }, 300);
    }
}

function get(code, answer, func_param)
{
    if (code == "success")
    {
        $context = func_param[0];
        $context.html(answer);
       
        $context.find(".phone").mask("?7 (999) 999-99-99", {autoclear: false});
        
        clear_error($context);
        
        if (rels = $context.data("rel"))
        {
            arRel = rels.split(",");
            for (i=0; i<arRel.length; i++)
            {
                refresh_context($("#" + arRel[i]));
            } 
        }
    }
     
    if (code == "refresh_page")
    {
        window.location.reload();
    }
}



function clear_error($context)
{
    wrapper = $context.attr("id");
    
    if (timeout[wrapper]) { 
        clearTimeout(timeout[wrapper]);  }
                        
    timeout[wrapper] = setTimeout(function(){
        $context.find(".form .error-message").html("");
        $context.find("form .input-error").removeClass("input-error");
    }, 2000);
}

$(function() {
    
    $("body").on("keypress", ".form input[type=text], input[type=password]", function(e) {
        if(e.which == 13) {
            $(this).closest(".form").find("[type=button]").trigger("click");
        }
    });
    
    $("body").on("change", ".form [name=id], .form.filter select", function(){
         $context = $(this).closest(".wrapper");
         refresh_context($context);
    });
    
     $("body").on("click", ".pagination ul a", function(){
        if (!$(this).hasClass("active"))
        {
            $context = $(this).closest(".wrapper");
            
            $context.find(".pagination a.active").removeClass("active");
            $(this).addClass("active");
            
            doPostAjax(get_mas($context), "get", [$context]); 
        }
        return false;
    });
    
    $("body").on("click", ".pagination a#pagination-left", function(){
        $context = $(this).closest(".wrapper");
        $prev = $context.find(".pagination a.active").closest("li").prev();
        if ($prev.length>0)        
        {
            $context.find(".pagination a.active").removeClass("active");
            $prev.find("a").addClass("active");
            doPostAjax(get_mas($context), "get", [$context]); 
        }
        return false;
    });
    
    $("body").on("click", ".pagination a#pagination-right", function(){
        $context = $(this).closest(".wrapper");
        $next = $context.find(".pagination a.active").closest("li").next();
        if ($next.length>0)
        {
            $context.find(".pagination a.active").removeClass("active");
            $next.find("a").addClass("active");
            doPostAjax(get_mas($context), "get", [$context]); 
        }
        return false;
    });
    
    $("body").on("click", ".change-mode a", function(){
        $context = $(this).closest(".wrapper");
        mas = get_mas($context);
        mas["args"]["mode"] = $(this).data("mode");
        doPostAjax(mas, "get", [$context]);
        return false;
    });
    
    $("body").on("click", ".change-screen", function(){
        doPostAjax({"op" : "screen", "args": {"number": $(this).data("screen")}}, "change_screen");
        return false;
    });
    
    $("body").on("click", ".form [type=button]", function(){
    
        $form = $(this).closest(".form");
        $error = $form.find(".error-message");
        $form.find(".input-error").removeClass("input-error");
        $context = $(this).closest(".wrapper");
             
        error = [];
        error_t = [];
        
        if ($(".form [name=delete]:checked").length == 0)
        {
            $form.find(".required").each(function(){
                if ($(this).val() == "" || ($(this).val() == "0" && $(this).is("select")))
                {
                    error.push(strong($(this).data("error")));
                    $(this).addClass("input-error");
                }
                /*else
                {
                    if ($(this).hasClass("phone"))
                    
                    if ($(this).hasClass("email"))
                    {
                        if (!validateEmail($(this).val())
                        {
                            error_t[] = 
                        }
                    }
                }*/    
            });
        }
        error_str = form_err_str(error);

        if (!error_str)
        {
            mas = get_mas($context);
            mas["args"]["on_submit"] = 1;
            doPostAjax(mas, "get", [$context]); 
        }   
        else
        {
            $error.html(error_str);
            clear_error($context);
        }            

        return false;            
    });
    
    $(".phone").mask("?7 (999) 999-99-99", {autoclear: false});
});
