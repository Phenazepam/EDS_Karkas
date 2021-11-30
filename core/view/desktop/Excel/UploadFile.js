function ShowModalForUpload(dictionary) {

    Swal.fire({
        title: 'Загрузка файла',
        /* input: "file", */
        html:
        `<form id="formElem" enctype="multipart/form-data">
            <hr>
            <a href="/excel-tutorial" target="_blank">Инструкция по импорту</a>
            <hr>
            <input type="file" name="dataFile">
        </form>`,
        showCancelButton: true,       
        preConfirm: async () => {
            let formData = new FormData(document.querySelector("#formElem"));
            formData.append("dictionary", dictionary)
            let response = await fetch('/dashboard?action=oexcel.uploadfile.do', {
                method: 'POST',
                /* headers: {
                  'Content-Type': 'application/json;charset=utf-8'
                }, */
                body: formData
              }).then(function (response) {
				return response;
			});
            // console.log(response);
            if (response.ok) {
                const res = await response.json();
                let output =`<div>Имортировано записей: ${res.uploadedCount}</div><hr>`
                output +=`<div><b>Список ошибок импорта:</b></div>`
                output+= '<textarea cols="30" rows="7" disabled style="width: 500px">\n';
                for(let i in res.errors){
                    output += res.errors[i] + '\n'
                }
                output+='</textarea>';
                if(res.responseCode == 'success'){
                    Swal.fire({
                        title: "Успешно",
                        html: output,
                        icon: 'success',
                        preConfirm: () => {
                             location.reload()
                        }
                    })
                }
                else{
                    Swal.fire({
                        title: "Ошибка",
                        html: output,
                        icon: 'error',
                    })
                }
            }
        }
      })
      
}
