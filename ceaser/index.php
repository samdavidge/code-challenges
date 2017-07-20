<?php

include('Ceaser.class');

$ceaser = new Ceaser\Ceaser();

?>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Ceaser</title>

    <meta name="description" content="Ceaser Encyyption Challenge">
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

    <form name="encrypt" action="" method="post">

        <label> Ceaser Encryption </label>

        <input type="text" name="message" value="message" required>

        <select name="method">
            <option value="1">Encrypt</option>
            <option value="2">Decrypt</option>
        </select>


        <input name="offset" type="number" min="1" max="25" value="1" required>


        <input type="submit" value="Go go go">

    </form>

    <div id="results">

        <?php if(!empty($_POST)): ?>



            <?php echo $_POST['message']; ?>
            ->
            <?php echo $_POST['method'] == 1 ? $ceaser->encrypt($_POST['message'], $_POST['offset']) : $ceaser->decrypt($_POST['message'], $_POST['offset']); ?>

        <?php endif; ?>

    </div>

</body>
</html
