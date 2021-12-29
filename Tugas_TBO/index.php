<?php 
include_once("func.php");
include_once("CFG.php");
include_once("CYK.php");

if( isset($_POST['submit']) ){
    if( isset($_POST['stcInput']) && !empty($_POST['stcInput']) ){

        $sentence = $_POST['stcInput'];
        $cfg = new CFG(get_rules("./rule/rules.txt"), "K"); // buat cfg
        $cyk = new CYKGenerator($cfg); // buat cyk
        $cyk = $cyk->generate_table($sentence);
        $cyk = $cyk->solve();

        if( $cyk->validation() ){
            $message =  "Kalimat Valid";
        }else{
            $message = "Kalimat Tidak Valid";
        }
    }
}

if( isset($_POST['files']) ){
    if( isset($_FILES['fileTest'])  && isset($_FILES['fileValid'])){
        //$fileTest = save($_FILES['fileTest']);
        //$fileValid = save($_FILES['fileValid']);

        // test
        $status = [];
        $tests = read_file("./data/$fileTest");
        $cfg = new CFG(get_rules("./rule/rules.txt"), "K"); // buat cfg
        $cyk = new CYKGenerator($cfg); // buat cyk
        foreach( $tests as $test ){
            $test = trim($test, ".");
            
            $cyk = $cyk->generate_table($test);
            $cyk = $cyk->solve();
            if( $cyk->validation() ){
                $status[] =  "valid";
            }else{
                $status[] = "invalid";
            }
        }

        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas TBO</title>
</head>
<body>

    <div class="container">
        <div class="section1">
            <h2>Parsing Bahasa Bali</h2>
            <div class="form">
                <form action="./index.php" method="POST">
                    <label for="sentence">Masukan Kalimat : </label>
                    <input type="text" id="sentence" name="stcInput" value="<?php if( isset($sentence) ) echo $sentence;?>">

                    <button type="submit" name="submit" class="mybtn green">submit</button>
                </form>
            </div>
        </div>
        <hr class="line">
        <div class="section2">
            <?php if( isset($sentence) ) : ?>
                <h2 class="<?php echo $color; ?>"><?php echo $message; ?>.</h2>
            <?php endif; ?>
        </div>
    </div>
    
</body>
</html>