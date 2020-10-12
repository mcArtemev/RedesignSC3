<?
    foreach (array('phrase', 'words') as $v)
      $$v = isset($_POST[$v]) ? $_POST[$v] : '';      
    
    $itog = array();
    
    $phrase_array = explode("\n", $phrase);
    $words_array =  explode("\n", $words);
    
    for($i=0; $i<count($phrase_array); $i++)
    {
        if (!isset($words_array[$i])) $words_array[$i] = '';

        $words_array[$i] = trim(preg_replace("/(\s){2,}/", ' ', $words_array[$i]));
        $phrase_array[$i] = trim(preg_replace("/(\s){2,}/", ' ', $phrase_array[$i]));

        $t = array_diff(explode(' ', $phrase_array[$i]), explode(' ', $words_array[$i]));
        $itog[$i] = ($t) ? implode(' ', $t) : '';
    }
    
    $itog = implode("\n", $itog);
    
?>
<!DOCTYPE>
<html>
<head>
    <title>Минус слова</title>
    <style>
        .field {
            margin-bottom: 2em;
            box-sizing: border-box;
            float: left;
            padding: 2em;
        }
        form {
            width: 100%;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 1em;
        }
        textarea {
            height: 8em;
            resize: none;
            width: 100%;
        }
    </style>
</head>
<body>
    <form action="minus.php" method="post">
        <div class="field" style="width: 40%;">
            <label>Фраза</label>
            <textarea name="phrase"><?=$phrase?></textarea>
        </div>
        <div class="field" style="width: 20%;">
            <label>Слова</label>
            <textarea name="words"><?=$words?></textarea>
            <input name="submit" type="submit" value="Вычесть" style="margin-top: 2em;"/>
        </div>
        <div class="field"  style="width: 40%;">
            <label>Результат</label>
            <textarea name="itog"><?=$itog?></textarea>
        </div>
    </form>
</body>
</html>