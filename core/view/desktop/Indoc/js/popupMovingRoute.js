async function popupMovingRoute(oindocId, isBack = 0) {

    const option = {
        method: "GET",
    }  
    let url = `/popupMovingRoute?oindoc_id=${oindocId}&isback=${isBack}`
    const response = await fetch(url, option);
    let txt = await response.text();
    // console.log(response);
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
            const response = await fetch("/indocitems-form-view?action=oindoc.ajaxMoveRoute.do", option);
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