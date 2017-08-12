<?php

include('Abbreviator.php');

?>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Abbreviation</title>

    <meta name="description" content="Abbreviation Challenge">
    <meta name="author" content="Sam Davidge">

    <style>

        form, div{
            width: 30%;
            margin: auto;
        }

        input, select{
            width: 100%;
            padding: 5px;
            margin: 5px;
        }

        #results{
            padding: 10px 0 10px 0;
        }

    </style>

</head>

<body>

<form name="abbreviate" action="" method="post">

    <label> Abbreviation </label>

    <input type="text" name="sentence" value="<? echo !empty($_POST) ? $_POST['sentence'] : '';?>">

    <select name="method">
        <option value="replace" >Replace</option>
        <option value="shuffle">Shuffle</option>
    </select>

    <input type="submit" value="Go go go">

</form>

<div id="results">

    <?php if(!empty($_POST)): ?>


        <?php $abbreviator = new Abbreviation\Abbreviator($_POST['sentence']); ?>

        <?= $_POST['sentence']; ?>

        <br>
        becomes
        <br>

        <?= $abbreviator->main($_POST['method']); ?>


    <?php endif; ?>

</div>

</body>
</html
