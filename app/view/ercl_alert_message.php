<?php
// ok #04AA6D
// errer #f44336
function  ercl_alert_message ($alert,$color){ ?>
  
        <div class='ercl_alert'>
            <span class='ercl_closebtn' onclick='this.parentElement.style.display=none'>&times;</span> 
            <strong>Cloodo</strong> <?php echo(esc_attr( $alert )); ?>
        </div>
        <style>
            .ercl_alert {
            position: fixed;
            top: 40px;
            left: 500px;
            padding: 20px;
            background-color: <?php echo(esc_attr($color)) ?>;
            color: white;
            border-radius: 5px;
            }

            .ercl_closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
            }

            .ercl_closebtn:hover {
            color: black;
            }
        </style>
        <script>
        window.setTimeout(function() {
                document.querySelector('.ercl_alert').remove(); 
        }, 2500);
        document.querySelector('.ercl_closebtn').onclick = function(){
            document.querySelector('.ercl_alert').style.display='none';
        };
        </script>
<?php
}