async function popupAddingRelatedDoc(docId) {

    const option = {
        method: "GET",
    }  
    let url = `/ajax-docsforchoose?doc_id=${docId}`
    const response = await fetch(url, option);
    let txt = await response.text();
    
    // console.log(response);
    Swal.fire({
        html: txt,
        showCancelButton: true,
        confirmButtonText: 'Сохранить',
        cancelButtonText: 'Отмена',
        width: 1000,
        didOpen: () => {
            $('#datatableForRelated').DataTable();
        },
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

async function popupForDeletingRelatedDoc(id, txt) {
  Swal.fire({
    title: "Удаление",
    text: "Вы уверены, что ходите удалить связанный документ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Да",
    cancelButtonText: "Нет",
  }).then(async (result) => {
    if (result.isConfirmed) {
      let formData = new FormData();
      formData.append("orelateddocs[id]", id);
      const option = {
        method: "POST",
        body: formData,
      };
      const response = await fetch(
        "/doctyperolematrix-list?action=relateddoc.deleterelateddoc.do",
        option
      );
      var res = await response.text();
        // console.log(res);
        location.reload();
    }
  });
}