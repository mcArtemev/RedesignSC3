<?php 
include 'links.php';
include 'base.php';

?>

<title>
    <?php
        foreach ($links as $key => $value) {
            if ($key == $url) {
                echo $value[1];
                break;
            } else {
                continue;
            }
        }
        ?>
</title>

<meta charset="utf-8">
<meta name=“robots” content=“noindex,nofollow”>
<link rel="stylesheet" href="<?=$sripts?>css/uikit.min.css" />
<script src="<?=$sripts?>js/uikit.min.js"></script>
<script src="<?=$sripts?>js/uikit-icons.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<nav class="uk-navbar-container uk-margin" uk-navbar="mode: click">
    <div class="uk-navbar-center">
        <ul class="uk-navbar-nav">
            <?php foreach ($links as $key => $value) { ?>
            <?php if (empty($value[0])) { continue; } else { ?>
            <li class="uk-text-bold<?php if ($url == $key && !empty($value[0])) { echo ' uk-active'; } ?>"> 
                <a href="<?php echo $key; ?>">
                            <?php echo $value[0]; ?>
                        </a>
            </li>
             <?php } ?>
            <?php } ?>
        </ul>
    </div>
</nav>

<div class="uk-container">
    <h2 class="uk-text-center">
        <?php
        foreach ($links as $key => $value) {
            if ($key == $url) {
                echo $value[1];
                break;
            } else {
                continue;
            }
        }
        ?>
    </h2>
</div>