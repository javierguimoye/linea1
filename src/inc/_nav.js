export default {
    home: '/clients',
    items: [
        {
            name: 'Dashboard',
            url: '/dashboard',
            icon: 'icon-speedometer'
        },
        {
            name: 'Clientes',
            url: '/clients',
            icon: 'icon-user'
        },
        {
            name: 'Multinivel',
            url: '/base',
            icon: 'icon-puzzle',
            children: [
                {
                    name: 'Item 1',
                    url: '/base/acs',
                    children: [
                        {
                            name: 'Item 1 1',
                            url: '/base/acs'
                        },
                        {
                            name: 'Item 1 2',
                            url: '/base/breadcrumbs'
                        }
                    ]
                },
                {
                    name: 'Item 2',
                    url: '/base/breadcrumbs'
                }
            ],
        }
    ],
    shortcuts: [
        /*{
            name: 'Configuraciones',
            url: '/settings',
            icon: 'gear'
        },
        {
            name: 'Mis OTS',
            url: '/ots',
            icon: 'star'
        },*/
        /*{
            name: 'Clientes',
            url: '/clients',
            icon: 'user'
        }*/
    ]
};
