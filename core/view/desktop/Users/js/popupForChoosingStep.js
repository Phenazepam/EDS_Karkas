async function popupForChoosingSteps(doctypeId,roleId) {

    const option = {
        method: "GET",
    }  

    const response = await fetch("/popupForChoosingStep?doctype_id="+doctypeId+'&role_id='+roleId, option);
    let txt = await response.text();
    console.log(response);
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
            console.log(formData);
            const response = await fetch("/doctyperolematrix-list?action=doctyperolematrix.store.do", option);
            var text = await response.text();
            console.log(text);
            location.reload();
        }
    })
}