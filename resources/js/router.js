import DashboardLayout from "./pages/Layout/DashboardLayout.vue";
// import Dashboard from "./pages/Dashboard.vue";
// import Icons from "./pages/Icons.vue";
// import Maps from "./pages/Maps.vue";
// import Notifications from "./pages/Notifications.vue";
// import UserProfile from "./pages/UserProfile.vue";
// import TableList from "./pages/TableList.vue";
// import Typography from "./pages/Typography.vue";
// import UpgradeToPRO from "./pages/UpgradeToPRO.vue";
// import Test from "./pages/Test.vue";
// import Bots from "./pages/Bots.vue";
// import FAQ from "./pages/QuestionsReponse.vue";
// import Deploy from "./pages/Deploy.vue";
// import Register from "./pages/Register.vue";

import Login from "./pages/Login.vue";
import Logout from "./pages/Logout.vue";
// import Home from "./pages/projetjet/Home.vue";
// import Users from "./pages/projetjet/Users.vue";
import Profil from "./pages/projetjet/Profile.vue";

import Universite from "./pages/Admin/Universite.vue";
import Etablissement from "./pages/Admin/Etablissement.vue";
import Domaine from "./pages/Admin/Domaine.vue";
import Mention from "./pages/Admin/Mention.vue";
import Diplome from "./pages/Admin/Diplome.vue";
import Specialite from "./pages/Admin/Specialite.vue";
import Search from "./pages/Search.vue";


const routes = [{
    path: "/",
    component: DashboardLayout,
    redirect: "/gerer/universites",
    children: [
        // {
        //     path: "dashboard",
        //     name: "Dashboard",
        //     component: Dashboard,
        //     meta: {
        //         requiresAuth: true
        //     }
        // },
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta: {
                requiresVisitor: true
            }
        },
        {
            path: '/logout',
            name: 'Logout',
            component: Logout
        },

        // {
        //     path: "Utilisateurs",
        //     name: "Gérer les utilisateurs",
        //     component: Users,
        //     meta: {
        //         requiresAuth: true
        //     }
        // },
        {
            path: "/gerer/universites",
            name: "Gérer les universites",
            component: Universite,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/gerer/etablissements",
            name: "Gérer les établissements",
            component: Etablissement,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/gerer/domaines",
            name: "Gérer les domaines",
            component: Domaine,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/gerer/mentions",
            name: "Gérer les mentions",
            component: Mention,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/gerer/diplomes",
            name: "Gérer les diplomes",
            component: Diplome,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/gerer/specialites",
            name: "Gérer les spécialités",
            component: Specialite,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/rechercher",
            name: "Recherche",
            component: Search
        },
        // {
        //     path: "Home",
        //     name: "Home",
        //     component: Search,
        //     meta: {
        //         requiresAuth: false
        //     }
        // },




        {
            path: "profil",
            name: "Mon profil",
            component: Profil,
            meta: {
                requiresAuth: true
            }
        },

    ],


},


    {
        path: '/auth/:provider/callback',
        component: {
            template: '<div class="auth-component"></div>'
        }
    },
    {
        path: '**',
        redirect: '/'
    },
];

export default routes;
