<template>
    <div class="content">

        <div class="row text-left align-items-center">
            <div class="col-md-6">
                <img src="https://achraf-chaibi.tn/jesr/public/images/bridge.png" width="500px" v-if="!ar">
                <img src="https://achraf-chaibi.tn/jesr/public/images/bridge_ar.png" width="500px" v-else>
            </div>
            <div class="col-md-6">
                <div class="justify-content-center " :class="ar ? 'text-right' : 'text-left'">
                    <h1 class="title" v-if="!ar">Jesr</h1>
                    <h1 class="title" v-if="ar">جسر</h1>
                    <p class="description" v-if="!ar">
                        Cette application est dédiée aux organisations, associations et divers militants de la
                        société civile qui souhaitent s'engager dans l'effort national de dons pour contribuer à contrer
                        les effets du virus Corona sur la société.
                        Une liste de bénévoles est mise à votre disposition pour vous conseiller. Merci pour votre
                        coopération.
                    </p>
                    <p class="description" v-else>
                        هذة التطبيقة موضوعة على ذمة المنظمات والجمعيات ومختلف الناشطين بالمجتمع المدني الراغبين في
                        الانخراط في المجهود الوطني للتبرعات للمساهمة في مجابهة آثار فيروس كورونا على المجتمع.
                        .ويوضع على ذمتكم قائمة في المتطوعين لإرشادكم وتوجيهكم مع الشكر على حسن التعاون.
                    </p>

                    <router-link :to="'/don?ar='+ar">
                        <base-button type="warning" fill>{{!ar ?'Faire un don' : 'التبرع'}}</base-button>
                    </router-link>
                    <router-link :to="'/consulter/demandes?ar='+ar">
                        <base-button type="secondary" fill>{{!ar ?'Liste des demandes de dons' : ' قائمة طلبات التبرع'}}
                        </base-button>
                    </router-link>

                </div>

            </div>
        </div>

        <h1 class=" head title">{{!ar ?'Comment ça marche' : 'طريقة الاستعمال'}}</h1>


        <div class="row  text-left" v-if="!ar">
            <div class="col-md-4">
                <card class="card floating">
                    <img slot="image" class="card-img-top" src="https://achraf-chaibi.tn/jesr/public/images/1.png" alt="Card image cap">
                    <p class="card-text">Choisissez si vous êtes un particulier ou une association.</p>
                </card>
            </div>
            <div class="col-md-4">
                <card class="card floating">
                    <img slot="image" class="card-img-top" src="https://achraf-chaibi.tn/jesr/public/images/2.png" alt="Card image cap">
                    <p class="card-text">Remplissez le formulaire de dons.</p>
                </card>
            </div>
            <div class="col-md-4 lastCard">
                <card class="card floating ">
                    <img slot="image" class="card-img-top" src="https://achraf-chaibi.tn/jesr/public/images/3.png" alt="Card image cap">
                    <p class="card-text">Consultez le numéro que vous affiche l'application pour nous faire béneficier
                        de votre don.</p>
                </card>
            </div>
        </div>

        <div class="row  text-right" v-if="ar">
            <div class="col-md-4">
                <card class="card floating">
                    <img slot="image" class="card-img-top" src="https://achraf-chaibi.tn/jesr/public/images/3_ar.png" alt="Card image cap">
                    <p class="card-text">اتصل الرقم الذي يعرضه التطبيق للسماح لنا بالاستفادة من تبرعك
                    </p>
                </card>
            </div>
            <div class="col-md-4">
                <card class="card floating">
                    <img slot="image" class="card-img-top" src="https://achraf-chaibi.tn/jesr/public/images/2.png" alt="Card image cap">
                    <p class="card-text">املأ استمارة التبرع</p>
                </card>
            </div>
            <div class="col-md-4  lastCard">
                <card class="card floating">
                    <img slot="image" class="card-img-top" src="https://achraf-chaibi.tn/jesr/public/images/1_ar.png" alt="Card image cap">
                    <p class="card-text">اختر ما إذا كنت فردًا أو جمعية</p>
                </card>
            </div>
        </div>
        <h1 class=" head title">{{!ar ?'Sauvons notre Tunisie' : 'مع بعضنا ننقذو تونسنا' }}</h1>
        <div class="row text-left align-items-center">

            <div class="col-md-6">
                <div class="justify-content-center " :class="ar ? 'text-right' : 'text-left'">
                    <h1 class="title" v-if="!ar">Nous avons besoin de vous</h1>
                    <h1 class="title" v-if="ar">بلادك حاجتها بيك</h1>
                    <p class="description" v-if="!ar">
                        Nous avons besoin de vous , et sommes certains que vous seriez toujours là pour votre patrie ,
                        si vous pourriez nous aider prière de consulter cette liste pour mieux orienter votre don.
                    </p>
                    <p class="description" v-else>
                        بلادك في حاجة ليك و نحنا متأكدين الي بش تاقف معاها ، كان تحب تعاون هاو اكثر حاجات مستحقينهم ا
                        دخل و عمر الإستمارة و كون متاكد الي حاجتك بش تمشي في بلاصتها
                    </p>

                    <router-link :to="'/consulter/demandes?ar='+ar">
                        <base-button type="secondary" fill>{{!ar ?'Voir la liste des demandes' : 'قائمة الطلبات'}}
                        </base-button>
                    </router-link>
                </div>
            </div>
            <div class="col-md-6 text-right lastCard">
                <img src="https://achraf-chaibi.tn/jesr/public/images/people.svg" width="500px">
            </div>
        </div>


        <modal :show.sync="modals.userModal">
            <template slot="header">
                Merci pour votre Don
            </template>
            <template>
                <p>Nous vous remercions pour votre généreux Don! L'acteur <strong> {{acteur.name}}
                    {{acteur.lastname}}</strong> affilié à la Gouvernorat <strong>
                    {{acteur.adresse.gouvernorat}}</strong> va prendre en charge votre
                    Don
                </p>

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.userModal = false;"
                >Fermer
                </base-button
                >

            </template>
        </modal>
    </div>

</template>
<script>
    import {
        Card,
        BaseInput
    } from "../../components/index";

    import BaseButton from '../../components/BaseButton';
    import BaseRadio from '../../components/BaseRadio';
    import {Modal} from "../../components/index";

    export default {
        components: {
            Card,
            BaseInput,
            BaseButton,
            BaseRadio,
            Modal,

        },
        data() {
            return {
                modals: {
                    userModal: false
                },
                acteur: {
                    name: 'Achraf',
                    lastname: 'Chaibi',
                    adresse: {
                        gouvernorat: 'Tunis'
                    }
                },
                gouvernorats: ["Ariana",
                    "Beja",
                    "Ben Arous",
                    "Bizerte",
                    "Gabes",
                    "Gafsa",
                    "Jendouba",
                    "Kairouan",
                    "Kasserine",
                    "Kebili",
                    "Le Kef",
                    "Mahdia",
                    "La Manouba",
                    "Medenine",
                    "Monastir",
                    "Nabeul",
                    "Sfax",
                    "Sidi Bouzid",
                    "Siliana",
                    "Sousse",
                    "Tataouine",
                    "Tozeur",
                    "Tunis",
                    "Zaghouan"],
                type_dons: ['Argent',
                    'Nourriture',
                    'Ressources Humaines',
                    'Ressources Matérielles',
                    'Autres'],
                actions: ['Particulier', 'Association'],
                rtl: false,
                model: {
                    nom: 'Creative Code Inc.',

                    type_action: 'Particulier',
                    adresse: '',
                    gouvernorat: 'Ariana',
                    telephone: '',

                    type_don: 'Nourriture',
                    description: '',
                    motorise: false,
                    accord_utss: true,
                },

            }
        },
        methods: {
            saveDon() {
                if (this.modal.nom != '' || this.modal.adresse != '' || this.modal.description != '')
                    this.$store.dispatch('newDon', this.model)
                        .then(response => {
                            console.log(response);
                            //    this.acteur = response;
                            this.modals.userModal = true;
                        })

            }
        },
        computed: {
            ar() {
                if (this.$route.query.ar)
                    return this.$route.query.ar
                return '';
            },

        },
        mounted() {
            this.i18n = this.$i18n;
            if (this.enableRTL) {
                this.i18n.locale = 'ar';
                this.$rtl.enableRTL();
            }

        },
    }
</script>
<style scoped>
    .listDemande {
        list-style-type: none;
    }

    .big {
        font-size: 20px;
        color: #344675 !important;
    }

    @media screen and (min-width: 768px) {
        .content {
            padding: 120px;
        }
    }

    .title {
        color: #ff8d72 !important;
    }

    .head {
        margin-top: 220px;
        margin-bottom: 150px;
    }

    .card {
        background-color: #f5f6fa;
    }

    .description {
        color: black !important;
    }

    .tim-icons .icon-single-02 {
        color: black !important;
    }

    .input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
        border-color: rgba(29, 37, 59, 0.5) !important;
    }

    #particles-js {
        position: absolute;
        background-size: contain;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        overflow-y: hidden;
        z-index: -0;
    }

</style>
