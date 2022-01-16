async function popupRecognition(oindocId) {

    const option = {
        method: "GET",
    }  
    let url = `/recognition-popup?oindoc_id=${oindocId}`
    const response = await fetch(url, option);
    let txt = await response.text();
    // console.log(response);
    let file_id = -1;
    Swal.fire({
        title: 'Распознавание',
        html: txt,
        showCancelButton: true,
        confirmButtonText: 'Сохранить',
        cancelButtonText: 'Отмена',
        preConfirm: async () => {
            let formData = new FormData(
              document.querySelector("#popup")
            );
  
            const option = {
              method: "POST",
              body: formData,
            };
            // console.log(formData);
            const response = await fetch("/recognition-popup?action=orecognition.storefile.do", option);
            var res = await response.json();
            file_id = res.file_id;
            if (-1 === file_id) {
                Swal.fire(
                    'Ошибка!',
                    "При загрузке файла возникла ошибка",
                    'error'
                  )
            }
        }
    }).then( (result)=> {
        if (result.isConfirmed) {
            let timerInterval
            Swal.fire({
            title: 'Распознавание',
            html: 'Идет процесс распознавания. Пожалуйста, подождите',
            timerProgressBar: true,
            didOpen: async () => {
                Swal.showLoading()
                let fm = new FormData();
                fm.append('orecognition[file_id]', file_id);
    
                const option = {
                    method: "POST",
                    body: fm,
                };
                const response = await fetch("/recognition-popup?action=orecognition.ajaxGetBase64.do", option);
                var res = await response.json();
                var file = res.file;
    
                let payload = JSON.stringify(
                    [{
                        "file" : file,
                        "id": "1",
                        "extension": "JPG",
                        "id_file": file_id
                    }]
                )
                const option1 = {
                    method: "POST",
                    mode: 'cors', // no-cors, *cors, same-origin
                    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    credentials: 'same-origin', // include, *same-origin, omit
                    referrer: "about:client", // или "" для того, чтобы не послать заголовок Referer,
                    // или URL с текущего источника
                    referrerPolicy: "unsafe-url",
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': '*/*' 
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: payload,
                };
                let response1 = await fetch("http://176.119.159.70/recognaize", option1);
                res = await response1.json();

                if (typeof(res[0].error) != "undefined") {
                    Swal.fire(
                        'Ошибка!',
                        "При распознавании возникла ошибка: " + res[0].error,
                        'error'
                      )
                      return
                }

                let text = res[0].result[0].result.data[0][1].text;
                // let text = 'res[0].result[0].result.data[0][1].text';

                fm = new FormData();
                fm.append('orecognition[doc_id]', oindocId)
                fm.append('orecognition[file_id]', file_id)
                fm.append('orecognition[rec_text]', text)
                const option_store = {
                    method: "POST",
                    body: fm,
                };
                const response_store = await fetch("/recognition-popup?action=orecognition.ajaxStoreRecognition.do", option_store);
                res =  await response_store.json();
                if (res.result == 0){
                    Swal.fire(
                        'Распознавание',
                        'Документ успешно распознан.',
                        'success'
                    ).then( () => {
                        location.reload()
                    })
                }
                else {
                    Swal.fire(
                        'Ошибка!',
                        "При распознавании возникла ошибка",
                        'error'
                      )
                }
            },        
            })
        }
    })
    // }
    //     
    // })
}

async function ShowRecognition(rec_id){
    

    const option = {
        method: "GET",
    }  
    let url = `/recognition-popup-show?rec_id=${rec_id}`
    const response = await fetch(url, option);
    let txt = await response.text();
    Swal.fire({
        title: 'Распознанный текст',
        html: txt,
        showCancelButton: true,
        confirmButtonText: 'ОК',
        cancelButtonText: 'Отмена',
        width: '85%'
    })
}