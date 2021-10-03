async function saveDocViewEvent(oindocId, user_id) {
    let formData = new FormData();
    // ($doc_id = '', $action = '', $comment = '', $user_id = '')
    formData.append('doclog[id]', oindocId);
    formData.append('doclog[action]', 'Документ просмотрен');
    formData.append('doclog[user_id]', user_id);
    console.log(formData);
    const option = {
      method: "POST",
      body: formData,
    };
  let url = `/indocitems-form-view?action=doclog.ajaxRegisterDocLog.do`;
  const response = await fetch(url, option);
  // console.log(response);
}
