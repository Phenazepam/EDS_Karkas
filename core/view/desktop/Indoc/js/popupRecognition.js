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
                        'Accept': '*/*', 
						'access-control-allow-headers': '*',
						'access-control-allow-methods': '*',
						'access-control-allow-origin': '*',
						'access-control-expose-headers': '*',
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: payload,
                };
                // *old
				//let response1 = await fetch("http://176.119.159.70/recognaize", option1);
				let response1 = await fetch("http://5.63.153.163:32029/recognaize", option1);
				let response_word = await fetch("http://5.63.153.163:32030/recognaize", option1);
				let response_pdf = await fetch("http://5.63.153.163:32031/recognaize", option1);
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
				let json_string = JSON.stringify(text);
                fm.append('orecognition[doc_id]', oindocId)
                fm.append('orecognition[file_id]', file_id)
                fm.append('orecognition[rec_text]', '"' + json_string + '"')
                const option_store = {
                    method: "POST",
                    body: fm,
                };
                const response_store = await fetch("/recognition-popup?action=orecognition.ajaxStoreRecognition.do", option_store);
                res =  await response_store.json();

                res = await response_word.json();
                let text_w = res[0].result[0];

                fm_w = new FormData();
                fm_w.append('orecognition[doc_id]', oindocId)
                fm_w.append('orecognition[base_text]', text_w)
                fm_w.append('orecognition[extension]', 'docx')
                fm_w.append('orecognition[source_file_id]', file_id)

                const option_store_w = {
                    method: "POST",
                    body: fm_w,
                };

                const response_store_w = await fetch("/recognition-popup?action=orecognition.ajaxStoreRecognitionFromBase64.do", option_store_w);
                res = await response_store_w.json();

                res = await response_pdf.json();
                let text_p = res[0].result[0];

                fm_p = new FormData();
                fm_p.append('orecognition[doc_id]', oindocId)
                fm_p.append('orecognition[base_text]', text_p)
                fm_p.append('orecognition[extension]', 'pdf')
                fm_p.append('orecognition[source_file_id]', file_id)

                const option_store_p = {
                    method: "POST",
                    body: fm_p,
                };

                const response_store_p = await fetch("/recognition-popup?action=orecognition.ajaxStoreRecognitionFromBase64.do", option_store_p);
                res = await response_store_p.json();
                
                console.log(res);

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
        width: '95%'
    })
}