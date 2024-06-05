// Notification
const NOTIFICATION_POSITION = {
    TOP_LEFT: 'top-left',
    TOP_CENTER: 'top-center',
    TOP_RIGHT: 'top-right',
    BOTTOM_LEFT: 'bottom-left',
    BOTTOM_CENTER: 'bottom-center',
    BOTTOM_RIGHT: 'bottom-right',
}

const NOTIFICATION_COLOR = {
    PRIMARY: {
        actionTextColor: '#fff',
        backgroundColor: '#D21A26'
    },
    INFO: {
        actionTextColor: '#fff',
        backgroundColor: '#2196f3'
    },
    SUCCESS: {
        actionTextColor: '#fff',
        backgroundColor: '#00ab55',
        actionText: 'Success'
    },
    WARNING: {
        actionTextColor: '#fff',
        backgroundColor: '#e2a03f'
    },
    DANGER: {
        actionTextColor: '#fff',
        backgroundColor: '#e7515a'
    },
    SECONDARY: {
        actionTextColor: '#fff',
        backgroundColor: '#805dca'
    },
    DARK: {
        actionTextColor: '#fff',
        backgroundColor: '#3b3f5c'
    }
}

const NOTIFICATION_DURATION = 3000;


var main = {
    // Init main config
    init: () => {
        var menu = JSON.parse(localStorage.getItem('menu'));
        $('.menu-sidebar').html(main.generateSideBar(menu))
        main.getUrlActive(CURRENT_URL);

    },
    // Notification
    notification: (message = '', color = NOTIFICATION_COLOR.DARK, position = NOTIFICATION_POSITION.TOP_RIGHT) => {
        Snackbar.show({
            text: message,
            actionTextColor: color.actionTextColor,
            backgroundColor: color.backgroundColor,
            duration: NOTIFICATION_DURATION,
            pos: position,
            actionText: color.actionText
        })
    },
    // Sidebar
    generateSideBar: (data = [], parent = null) => {

        let dataItem = data.filter(f => f.parent_id === parent).sort((a, b) => {
            return a.order_menu - b.order_menu
        });
        let _html = '';
        _html = dataItem.reduce((result, item) => {
            if(item.type === 'section'){
                result += `
                <li class="menu menu-heading">
                    <div class="heading">
                        <i class="${item.icon}" style="vertical-align: middle;"></i>
                        <span>${item.title}</span>
                    </div>
                </li>
                `;
                result += main.generateSideBar(data, item.id);
            }else if(item.type === 'collapse'){
                let idCollapse = `collapse-menu-${item.id}`;
                function generateSideBarChild(pid = null){
                    let dataChildren = data.filter(f => f.parent_id === pid).sort((a, b) => {
                        return a.order_menu - b.order_menu
                    });
                    var htm = dataChildren.reduce((r, i) => {
                        if(i.type === 'item'){
                            r += `<li class=""><a class="" href="${BASE_URL(i.url)}"> ${i.title} </a></li>`
                        }else{
                            r += `<li>
                            <a href="#collapse-menu-children-${i.id}" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed"> ${i.title} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                            <ul class="collapse list-unstyled sub-submenu" id="collapse-menu-children-${i.id}" data-bs-parent="#pages">
                               ${generateSideBarChild(i.id)}
                            </ul>
                        </li>`

                        }
                        return r
                    }, '');
                    return htm
                }
                result += `
                <li class="menu">
                    <a href="#${idCollapse}" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="${item.icon}" style="vertical-align: middle;"></i>
                            <span>${item.title}</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="${idCollapse}" data-bs-parent="#accordionExample">
                        ${generateSideBarChild(item.id)}
                    </ul>
                </li>
                `;

            }else if(item.type === 'item'){

                result += `
                <li class="menu">
                    <a href="${BASE_URL(item.url)}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="${item.icon}" style="vertical-align: middle;"></i>
                            <span>${item.title}</span>
                        </div>
                    </a>
                </li>
                `;
            }

            return result;
        },'');

        return _html;
    },
    getUrlActive: (url = '') => {
        var urlToArray = url.split('/')
        var urlSearch = urlToArray.join('/');
        var elm = $('.menu-sidebar a[href="'+urlSearch+'"]');

        main.setParentActive(elm);

        if(urlToArray.length > 1 && elm.length === 0){
            urlToArray.splice(-1);
            main.getUrlActive(urlToArray.join('/'))
        }
    },
    setParentActive: (elm) => {
        elm.parent("li").addClass('active')

        var elmParent = elm.parent("li").parent("ul");
        if(elmParent.hasClass('submenu')) {
            elmParent.addClass('show');
            elmParent.parent('li').addClass('active')
            elmParent.parent('li').children('a').attr('aria-expanded', true)
        }else if(elmParent.hasClass('sub-submenu')){
            elmParent.addClass('show')
            main.setParentActive(elmParent.parent('li').children('a'))
            elmParent.parent('li').removeClass('active')
            elmParent.parent('li').children('a').attr('aria-expanded', true)
        }
    },
    // Confirm Delete
    confirmDelete: (url = '', elmTable = null) => {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            timerProgressBar: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Iya',
            preConfirm: async () => {
                try{
                    Swal.showLoading();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var data = await $.ajax({
                        type: 'DELETE',
                        dataType: 'json',
                        url: url,
                        data: {'_token': csrfToken}
                    })
                    return data;
                }catch(e){
                    Swal.showValidationMessage(`Gagal Menghapus data`);
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Dihapus!',
                'Data berhasil dihapus',
                'success'
                ).then(() => {
                    if(elmTable){
                        $(elmTable).DataTable().ajax.reload()
                    }else{
                        window.location.reload();
                    }
                })
            }
        })
    },
}

main.init();
