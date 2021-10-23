async function popupForChoosingSteps(doctypeId,roleId) {

    const option = {
        method: "GET",
    }  

    const response = await fetch("/popupForChoosingStep?doctype_id="+doctypeId+'&role_id='+roleId, option);
    let txt = await response.text();
    Swal.fire({
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
            const response = await fetch("/doctyperolematrix-list?action=doctyperolematrix.store.do", option);
            var res = await response.json();
            if (0 != res.errorCode) {
              Swal.fire(
                'Ошибка!',
                res.errorText,
                'error'
              )
            }
            else location.reload();
        }
    })
}

async function popupForDeletingStep(doctypeId, stepOrder, txt) {
  Swal.fire({
      title: 'Удаление',
      text: "Вы уверены, что ходите удалить шаг " + txt + "?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Да',
      cancelButtonText: 'Нет'
    }).then( async (result) => {
      if (result.isConfirmed) {
        let formData = new FormData();
        formData.append('doctyperolematrix[doctype_id]', doctypeId);
        formData.append('doctyperolematrix[stepOrder]', stepOrder);
        const option = {
          method: "POST",
          body: formData,
        };
        const response = await fetch("/doctyperolematrix-list?action=doctyperolematrix.delete.do", option);
        var res = await response.json();
        // var res = await response.text();
        // console.log(res);
        if (0 != res.errorCode) {
          Swal.fire(
            'Ошибка!',
            res.errorText,
            'error'
          )
        }
        else location.reload();
      }
    })
}