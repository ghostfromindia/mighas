jconfirm.defaults = {
    theme: 'material',
    closeIcon: true,
    backgroundDismiss: true,
    animation: 'zoom',
}
class Alerts{
    success(title,desc){
        $.alert({
            title: title,
            content: desc,
            type: 'green',
            autoClose: 'close|1000',
            buttons:{
                close: function () {

                }
            }
        })
    }
    error(title,desc){
        $.alert({
            title: title,
            content: desc,
            type: 'red'
        })
    }
    notice(title,desc){
        $.alert({
            title: title,
            content: desc,
            type: 'blue'
        })
    }
    warning(title,desc){
        $.alert({
            title: title,
            content: desc,
            type: 'orange'
        })
    }
}
const alerts = new Alerts;