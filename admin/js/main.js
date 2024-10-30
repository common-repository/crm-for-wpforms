window.onload = function(){
    for (let index = 0; index < document.querySelectorAll('.wp-submenu-head').length; index++) {
        if(document.querySelectorAll('.wp-first-item')[index].innerText == 'Erp Cloodo'){
            document.querySelectorAll('.wp-first-item')[index].style.display='none';
        }
    }
    document.getElementById("ercl_popup_admin_chat").onclick = function (){
        const ercl_para = document.createElement("iframe");
        ercl_para.id = 'ercl_main';
        ercl_para.src = 'https://worksuite.cloodo.com/apps/leads?tokenws=' + get_option_token;
        document.getElementById('wpbody-content').appendChild(ercl_para);
    }
    
}
