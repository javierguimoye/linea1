import Ots from "./views/ots";
import Clients from "./views/clients";
import Modules from "./views/modules";
//import ClientsForm from "./views/clients_form";
//import OtsForm from "./views/ots_form";
import Users from "./views/users";
//import UsersForm from "./views/users_form";
import E404 from "./views/e404";
import Managements from "./views/managements";
import Vehicles from "./views/vehicles";
import TypeServices from "./views/type_services";
import Competences from "./views/competences";
import Consumables from "./views/consumables";
import Materials from "./views/materials";
import DocumentSigs_horario from "./views/horarios";
import DocumentSigs_saldos from "./views/saldos";
import Personals from "./views/personals";
import Eventos from "./views/eventos";
import Kits from "./views/kits";
import Roles from "./views/roles";
import Settings from "./views/settings";
import Proveedores from "./views/proveedores";
import Tipo_gastos from "./views/tipo_gastos";
import Unidades from "./views/unidades";

import Choferes from "./views/choferes";
import Rutas from "./views/rutas";

const routes = [
    {path: '/404', component: E404},
    {path: '/ots', component: Ots},
    {path: '/users', component: Users},
    {path: '/clients', component: Clients},

    {path: '/proveedores', component: Proveedores},
    {path: '/tipo_gastos', component: Tipo_gastos},
    {path: '/unidades', component: Unidades},

    {path: '/choferes', component: Choferes},
    {path: '/rutas', component: Rutas},


    {path: '/managements', component: Managements},
    {path: '/vehicles', component: Vehicles},
    {path: '/type_services', component: TypeServices},
    {path: '/competences', component: Competences},
    {path: '/consumables', component: Consumables},
    {path: '/materials', component: Materials},
    {path: '/horarios', component: DocumentSigs_horario},
    {path: '/saldos', component: DocumentSigs_saldos},
    {path: '/personals', component: Personals},
    {path: '/eventos', component: Eventos},
    {path: '/kits', component: Kits},
    {path: '/modules', component: Modules},
    {path: '/roles', component: Roles},
    {path: '/settings', component: Settings}
];

export default routes;