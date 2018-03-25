// vars
var result = document.querySelector('.result'),
    img_result = document.querySelector('.img-result'),
    options = document.querySelector('.options'),
    save = document.querySelector('.save'),
    cropped = document.querySelector('.cropped'),
    uploadV = document.querySelector('#posterV'),
    uploadH = document.querySelector('#posterH'),
    posterVName = document.querySelector('#posterVName'),
    posterHName = document.querySelector('#posterHName'),
    poster = '',
    cropper = '';

// on change show image with crop options
uploadV.addEventListener('change', function (e) {
    poster = 'V';
    if (e.target.files.length) {
        // start file reader
        var reader = new FileReader();
        reader.onload = function (e) {
            if (e.target.result) {
                // create new image
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                // clean result before
                result.innerHTML = '';
                // append new image
                result.appendChild(img);
                // show save btn and options
                save.classList.remove('hide');
                options.classList.remove('hide');
                // init cropper
                cropper = new Cropper(image, {
                    aspectRatio: 300 / 418,
                    crop: function(event) {
                        console.log(event.detail.x);
                        console.log(event.detail.y);
                        console.log(event.detail.width);
                        console.log(event.detail.height);
                        console.log(event.detail.rotate);
                        console.log(event.detail.scaleX);
                        console.log(event.detail.scaleY);
                    }
                });
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// on change show image with crop options
uploadH.addEventListener('change', function (e) {
    poster = 'H';
    if (e.target.files.length) {
        // start file reader
        var reader = new FileReader();
        reader.onload = function (e) {
            if (e.target.result) {
                // create new image
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                // clean result before
                result.innerHTML = '';
                // append new image
                result.appendChild(img);
                // show save btn and options
                save.classList.remove('hide');
                options.classList.remove('hide');
                // init cropper
                cropper = new Cropper(image, {
                    aspectRatio: 300 / 128,
                    crop: function(event) {
                        console.log(event.detail.x);
                        console.log(event.detail.y);
                        console.log(event.detail.width);
                        console.log(event.detail.height);
                        console.log(event.detail.rotate);
                        console.log(event.detail.scaleX);
                        console.log(event.detail.scaleY);
                    }
                });
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// save on click
save.addEventListener('click', function (e) {
    e.preventDefault();
    // get result to data uri
    var imgSrc = cropper.getCroppedCanvas({
        //width: img_w.value // input value
        width: 300 // input value
    }).toDataURL();

    //上传图片
    var data={imgBase:imgSrc};
    $.post('../input/controller/imageUpload.php?source=movie',data,function(ret){
        if(ret=='false'){
            alert('存储失败');
        }else if(ret=='11') {
            alert('图片错误');
        }else{
            alert('图片已保存！');
            switch(poster){

                case 'V':
                    posterVName.setAttribute('value', ret);
                    break;
                case'H':
                    posterHName.setAttribute('value', ret);
                    break;

            }

        }
    },'text');


    // remove hide class of img
    cropped.classList.remove('hide');
    img_result.classList.remove('hide');
    // show image cropped
    cropped.src = imgSrc;
});