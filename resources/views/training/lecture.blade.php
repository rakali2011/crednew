<?php
$total_slides=0;
$path="";
?>
<!DOCTYPE html> 
<html>
    <head>
        <style>
            .leftmenu{
                width: 13%;
                margin: auto;
                display: flex;
                float: left;
                height:750px;
            }
            .leftmenu ul{
                list-style: none;
                line-height: 3em;
            }
            .leftmenu ul a{
                text-decoration: none;
                font-family: sans-serif;
                font-weight: bold;
            }
            .mainpanel{
                width: 70%; margin: 10px auto; display: flex;
            }
        </style>
    </head>
    
    <body>

        <div class="leftmenu" >
            <ul>
                <li><a href="?t=trainging_chap1" >Training Chapter1</a></li>
                <li><a href="?t=trainging_chap2" >Training Chapter2</a></li>
                <li><a href="?t=trainging_chap3" >Training Chapter3</a></li>
                <li><a href="?t=trainging_chap4" >Training Chapter4</a></li>
                <li><a href="index.php?logout=yes" >Logout</a></li>
            </ul>
        </div>
        <?php if(isset($_GET['t'])){
            $path = $_GET['t'];
            if($path=='trainging_chap1'){
                $total_slides = 133;
            } else if($path=='trainging_chap2'){
                $total_slides = 79;
            }else if($path=='trainging_chap3'){
                $total_slides = 79;
            }else if($path=='trainging_chap4'){
                $total_slides = 88;
            }
            ?>
        <div class="mainpanel">
            <img src="{{ asset('/images/training/'.$path.'/Slide1.GIF') }}" id="mainImage" name="mainImage" width="100%" height="70%" alt="">
        </div>
        
        <br/>
        <div style="width: 80%; margin: auto; text-align: center">
            <a href="#" onclick="swapImage(1);" title="First"><img src="{{ asset('/images/img/first.jpg') }} " width="32px" border=0 alt="First" tooltip="First"></a>
            <a href="#" onclick="swapImage(currentIndex-1);" title="Previous"><img src="{{ asset('/images/img/left.jpg') }}" width="32px" border=0 alt="Back"></a>
            <a href="#" onclick="swapImage(currentIndex + 1);" title="Next"><img src=" {{ asset('/images/img/right.jpg') }}" width="32px" border=0 alt="Next"></a>
            <a href="#" onclick="swapImage(maxIndex);" title="Last"><img src="{{ asset('/images/img/last.jpg') }}" width="32px" border=0 alt="Last"></a>
        </div>
        <div style="width: 80%; margin: auto; text-align: center;" >
            <label id="page_no"></label>
        </div>
        <?php }?>
        <!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=https://docuhub.com/exam/training/Headache-and-low-back-pain.pptx' width='80%' height='565px' frameborder='0'> </iframe>-->
        <!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://www.learningaboutelectronics.com/Articles/Headache-and-low-back-pain.pptx' width='80%' height='565px' frameborder='0'> </iframe>-->
        <!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=[https://www.your_website/file_name.pptx]' width='100%' height='600px' frameborder='0'>-->
        

    </body>
    <script type="text/javascript">
    //Initilize start value to 1 'For Slide1.GIF'
    var currentIndex = 1;

    //NOTE: Set this value to the number of slides you have in the presentation.
    var maxIndex=<?php echo $total_slides;?>;
//    var maxIndex=133;
    var current_img_url = document.getElementById("mainImage").src;

    function swapImage(imageIndex){
        var path = '<?php echo $path ;?>';
        current_img_url = document.getElementById("mainImage").src;
        //Check if we are at the last image already, return if we are.
        if(imageIndex>maxIndex){
            currentIndex=maxIndex;
            return;
        }

        //Check if we are at the first image already, return if we are.
        if(imageIndex<1){
            currentIndex=1;
            return;
        }

        currentIndex=imageIndex;
        // <?php $currentIndex = "<script>document.write(currentIndex)</script>"?>
        //Otherwise update mainImage
//        document.getElementById("mainImage").src='img/loader.gif';
        // document.getElementById("mainImage").src='training/'+path+'/Slide' +  currentIndex  + '.GIF';
        var base_url = '{!! url('/') !!}';
        var name1 = '/images/training/<?php echo $path?>/Slide'+currentIndex+'.GIF';


        document.getElementById("mainImage").src=base_url+name1;
        
        document.getElementById("page_no").innerText="("+currentIndex+"/"+maxIndex+")";
        return;
    }
    
    document.onkeydown = checkKey;

function checkKey(e) {

    e = e || window.event;

    if (e.keyCode == '38') {
        swapImage(currentIndex + 1);
        // up arrow
    }
    else if (e.keyCode == '40') {
        swapImage(currentIndex-1);
        // down arrow
    }
    else if (e.keyCode == '37') {
        swapImage(currentIndex-1);
       // left arrow
    }
    else if (e.keyCode == '39') {
        swapImage(currentIndex + 1);
       // right arrow
    }

}
</script>
</html>