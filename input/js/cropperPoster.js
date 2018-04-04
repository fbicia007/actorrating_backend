// vars
var result = document.querySelector('.result'),
    resultH = document.querySelector('.resultH'),
    resultA = document.querySelector('.resultA'),
    img_result = document.querySelector('.img-result'),
    img_resultH = document.querySelector('.img-resultH'),
    img_resultA = document.querySelector('.img-resultA'),
    options = document.querySelector('.options'),
    optionsH = document.querySelector('.optionsH'),
    optionsA = document.querySelector('.optionsA'),
    save = document.querySelector('.save'),
    saveH = document.querySelector('.saveH'),
    saveA = document.querySelector('.saveA'),
    cropped = document.querySelector('.cropped'),
    croppedH = document.querySelector('.croppedH'),
    croppedA = document.querySelector('.croppedA'),
    uploadV = document.querySelector('#posterV'),
    uploadH = document.querySelector('#posterH'),
    uploadA = document.querySelector('#photo'),
    posterVName = document.querySelector('#posterVName'),
    posterHName = document.querySelector('#posterHName'),
    photoName = document.querySelector('#photoName'),

    poster = '',
    posterA = '',
    posterH = '',
    cropper = '',
    cropperA = '',
    cropperH = '';

// on change show image with crop options
uploadA.addEventListener('change', function (e) {
    posterA = 'A';
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
                resultH.innerHTML = '';
                resultA.innerHTML = '';
                // append new image
                resultA.appendChild(img);
                // show save btn and options
                saveA.classList.remove('hide');
                save.classList.add('hide');
                optionsA.classList.remove('hide');
                options.classList.add('hide');
                // init cropper
                cropperA = new Cropper(image, {
                    aspectRatio: 300 / 450,
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
        $('#saveActor').prop('disabled', true);
    }
});

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
                resultA.innerHTML = '';
                resultH.innerHTML = '';
                result.innerHTML = '';
                // append new image
                result.appendChild(img);
                // show save btn and options
                save.classList.remove('hide');
                saveH.classList.add('hide');
                options.classList.remove('hide');
                optionsH.classList.add('hide');
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
        $('#saveMovie').prop('disabled', true);
    }
});

// on change show image with crop options
uploadH.addEventListener('change', function (e) {
    posterH = 'H';
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
                resultA.innerHTML = '';
                resultH.innerHTML = '';
                // append new image
                resultH.appendChild(img);
                // show save btn and options
                saveH.classList.remove('hide');
                save.classList.add('hide');
                optionsH.classList.remove('hide');
                options.classList.add('hide');
                // init cropper
                cropperH = new Cropper(image, {
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
        $('#saveMovie').prop('disabled', true);
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
                    cropped.classList.remove('hide');
                    img_result.classList.remove('hide');
                    cropped.src = imgSrc;
                    break;
                case'H':
                    posterHName.setAttribute('value', ret);
                    croppedH.classList.remove('hide');
                    img_resultH.classList.remove('hide');
                    croppedH.src = imgSrc;
                    break;

            }
            $('#saveMovie').prop('disabled', false);

        }
    },'text');


    // remove hide class of img
    /*
    cropped.classList.remove('hide');
    croppedH.classList.remove('hide');
    img_result.classList.remove('hide');
    img_resultH.classList.remove('hide');
    // show image cropped
    cropped.src = imgSrc;
    croppedH.src = imgSrc;
    */
});
// save on click
saveH.addEventListener('click', function (e) {
    e.preventDefault();
    // get result to data uri
    var imgSrc = cropperH.getCroppedCanvas({
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
            switch(posterH){

                case 'V':
                    posterVName.setAttribute('value', ret);
                    cropped.classList.remove('hide');
                    img_result.classList.remove('hide');
                    cropped.src = imgSrc;
                    break;
                case'H':
                    posterHName.setAttribute('value', ret);
                    croppedH.classList.remove('hide');
                    img_resultH.classList.remove('hide');
                    croppedH.src = imgSrc;
                    break;

            }
            $('#saveMovie').prop('disabled', false);

        }
    },'text');

    // remove hide class of img
    /*
    cropped.classList.remove('hide');
    croppedH.classList.remove('hide');
    img_result.classList.remove('hide');
    img_resultH.classList.remove('hide');
    // show image cropped
    cropped.src = imgSrc;
    croppedH.src = imgSrc;
    */
});

// save on click
saveA.addEventListener('click', function (e) {
    e.preventDefault();
    // get result to data uri
    var imgSrc = cropperA.getCroppedCanvas({
        //width: img_w.value // input value
        width: 300 // input value
    }).toDataURL();

    //上传图片
    var data = {imgBase: imgSrc};
    $.post('../input/controller/imageUpload.php?source=actor', data, function (ret) {
        if (ret == 'false') {
            alert('存储失败');
        } else if (ret == '11') {
            alert('图片错误');
        } else {
            alert('图片已保存！');

            photoName.setAttribute('value', ret);
            croppedA.classList.remove('hide');
            img_resultA.classList.remove('hide');
            croppedA.src = imgSrc;

            $('#saveActor').prop('disabled', false);

        }
    }, 'text');
});