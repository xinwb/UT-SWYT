  function searchlink(){
            var y=document.getElementById('searchbyuse');
            var x=document.getElementById('searchuse');
            var bywhat = y.innerHTML;
            var bydata = x.value;
            var url = '{:U('grxxgl',array('bywhat'=>'bydata'))}';
            var urlfinal;
            if(bydata == ''){

                urlfinal ='{:U('grxxgl')}';
            }else{
                var responuse = bywhat+'/'+bydata;
                 urlfinal = url.replace('bywhat/bydata',responuse);
            }
            window.open(urlfinal,'_self');

        }
        function searchby(obj){
            var x=document.getElementById('searchby');
            var y=document.getElementById('searchbyuse');
            var bywhat = obj.name;
            if(bywhat == 'xm'){
                y.innerHTML='ixm';
            }else{
             y.innerHTML='iname';
            }
           x.innerHTML = obj.innerHTML;
       }
