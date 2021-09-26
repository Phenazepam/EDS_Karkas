async function popupMovingRoute(oindocId, cstep, crole) {

    const option = {
        method: "GET",
    }  
    let url = `/popupMovingRoute?oindoc_id=${oindocId}&cstep=${cstep}&crole=${crole}`
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
            var text = await response.text();
            // console.log(text);
            location.reload();
        }
    })
}