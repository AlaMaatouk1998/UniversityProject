<template>
    <div class="content">
        <card>
            <template slot="header">
                <h5 class="title" :class="!ar ? 'float-left': 'float-right'">{{!ar ?'Faire un don' : 'التبرع'}}</h5>
            </template>
            <form action="#" role="form" @submit.prevent="saveDon">
                <div class="row">

                    <div class="col-md-6 " :class="!ar ? 'text-left': 'text-right'">
                        <base-input :label="!ar ? 'Affiliation' :'الانتماء'">
                            <select class="form-control" v-model="model.type_action" :dir="ar ? 'rtl' : ''">
                                <option v-for="(action, index) in actions"
                                        :value="action.fr"
                                        :key="index"
                                >{{!ar ? action .fr: action.ar}}
                                </option>
                            </select>
                        </base-input>
                    </div>
                    <div class="col-md-6  " :class="!ar ? 'text-left': 'text-right'">
                        <base-input :label="getName()"
                                    :placeholder="getName()"
                                    v-model="model.nom"
                                    :dir="ar ? 'rtl' : ''"
                                    type="text"
                        >
                        </base-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 pr-md-1 " :class="!ar ? 'text-left': 'text-right'">
                        <base-input :label="!ar ? 'Adresse' : 'العنوان'"
                                    v-model="model.adresse"
                                    :placeholder="!ar ? 'Adresse' : 'العنوان'"
                                    :dir="ar ? 'rtl' : ''"
                                    type="text"
                        >
                        </base-input>
                    </div>
                    <div class="col-md-4 px-md-1 " :class="!ar ? 'text-left': 'text-right'">
                        <base-input :label="!ar ? 'Gouvernorat' : 'الولاية'">
                            <select class="form-control" v-model="model.gouvernorat" :dir="ar ? 'rtl' : ''">
                                <option v-for="(gouvernorat, index) in gouvernorats"
                                        :value="gouvernorat.fr"
                                        :key="index"
                                >{{!ar ? gouvernorat.fr : gouvernorat.ar}}
                                </option>
                            </select>
                        </base-input>
                    </div>
                    <div class="col-md-4 pl-md-1 " :class="!ar ? 'text-left': 'text-right'">
                        <base-input :label="!ar ? 'Téléphone' : 'الهاتف'"
                                    :placeholder="!ar ? 'Telephone' : 'الهاتف'"
                                    type="tel"
                                    v-model="model.telephone" :dir="ar ? 'rtl' : ''">
                        </base-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 " :class="!ar ? 'text-left': 'text-right'">
                        <base-input :label="!ar ? 'Type du don' : 'نوع التبرع'">
                            <select class="form-control" v-model="model.type_don" :dir="ar ? 'rtl' : ''">
                                <option v-for="(type_don, index) in type_dons"
                                        :value="type_don.fr"
                                        :key="index"
                                >{{!ar ? type_don.fr : type_don.ar}}
                                </option>
                            </select>
                        </base-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 " :class="!ar ? 'text-left': 'text-right'">
                        <base-input>
                            <label>{{ !ar ? 'Description de votre don' : 'وصف التبرع'}}</label>
                            <textarea rows="4" cols="80"
                                      class="form-control"
                                      :placeholder=" !ar ? 'Description de votre don' :  'وصف التبرع'"
                                      v-model="model.description" :dir="ar ? 'rtl' : ''">
              </textarea>
                        </base-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 " :class="!ar ? 'text-left': 'text-right'">
                        <base-checkbox class="mb-3" v-model="model.motorise" :dir="ar ? 'rtl' : ''">
                            {{!ar ? 'Etês-vous motorisé ?' : 'مجهز بعربة'}}

                        </base-checkbox>

                        <!--            <base-checkbox class="mb-3" v-model="model.accord_utss" :dir="ar ? 'rtl' : ''">-->
                        <!--                {{!ar ? "Est-ce que vous acceptez que votre don soit pris en charge par l'UTSS (Union Tunisienne de Solidarité Sociale)?  " : 'هل تقبل أن تبرعك تتكفل به UTSS (الاتحاد التونسي للتضامن الاجتماعي)؟'}}-->

                        <!--            </base-checkbox>-->

                    </div>
                </div>
                <base-button :class="!ar ? 'float-left' : 'float-right'" type="success" fill nativeType="submit">{{!ar
                    ?'Faire un don' : 'التبرع'}}
                </base-button>
            </form>


        </card>
        <modal :show.sync="modals.userModal">
            <template slot="header">
                {{!ar ? 'Merci pour votre Don' : 'شكرا'}}
            </template>
            <template>
                <p class="text-left" v-if="!ar">Nous vous remercions pour votre généreux Don!<strong> {{acteur.name}}
                </strong>, représentant(e) de <strong>{{acteur.lastname}}</strong> ayant le
                    numéro de téléphone :
                    <strong> {{acteur.telephone}}</strong>, prendra en charge votre Don!
                </p>
                <p class="text-right" v-else>للتكفل بتبرعكم الرجاء الاتصال بالسيد(ة)
                    <br>
                    <strong>{{acteur.name}}</strong>
                    <br>
                    ممثل(ة) عن
                    <br>
                    <strong>{{acteur.lastname}}</strong>
                    <br>
                    و رقمه(ها)
                    <br>
                    <strong>{{acteur.telephone}} </strong>

                </p>

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.userModal = false;"
                >{{!ar ? 'Fermer' : 'اغلاق'}}
                </base-button
                >

            </template>
        </modal>
        <modal :show.sync="modals.infos">
            <template slot="header">
                {{!ar ? 'Merci pour votre Don' : 'شكرا'}}
            </template>
            <template>
                <p>Union Nationale de la Femme Tunisienne: +216 71 378 447 الاتحاد الوطني للمرأة التونسية</p>
                <p>Croissant Rouge: +216 71 378 447 الهلال الاحمر التونسي</p>
                <p>Le Scoutisme: +216 71 378 447 الكشافة التونسية</p>
            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.infos = false;"
                >{{!ar ? 'Fermer' : 'اغلاق'}}
                </base-button>

            </template>
        </modal>
        <modal :show.sync="modals.choseActeur">
            <template slot="header">
                {{!ar ? 'Choisissez parmi ces acteurs lequel prendra en charge votre don' : 'اختر من بين هؤلاء الممثلين من يتكفل بتبرعك'}}
            </template>
            <template>
                <div class="table-responsive">
                    <table class="table tablesorter text-left">
                        <thead class="text-primary">
                        <tr>
                            <slot nom="columns">
                                <th>{{!ar ? 'Listes des organisations et associations partenaires' : 'قائمة المنظمات و الجمعيات الشريكة '}}
                                </th>
                                <th>&nbsp;</th>
                            </slot>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(act, index) in acteurs" :key="index">
                            <td> {{act.lastname}}</td>
                            <td>
                                <base-button class="float-right" type="primary" fill v-on:click="choseUnActeur(act)">
                                    {{!ar
                                    ?'Choisir' : 'اختيار'}}
                                </base-button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.infos = false;"
                >{{!ar ? 'Fermer' : 'اغلاق'}}
                </base-button>

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
            Modal
        },
        data() {
            return {
                modals: {
                    userModal: false,
                    infos: false,
                    choseActeur: false
                },
                acteur: {
                    name: 'Etat',
                    lastname: 'Tunisie',
                    adresse: {
                        gouvernorat: 'Tunis'
                    }
                },

                type_dons: [{fr: 'Argent', ar: 'موارد مالية'},
                    {fr: 'Nourriture', ar: 'مواد غذائية'},
                    {fr: 'Ressources Humaines', ar: 'موارد بشرية'},
                    {fr: 'Ressources Materiels', ar: 'أجهزة'},
                    {fr: 'Autres', ar: 'اخر'}],
                actions: [{fr: 'Particulier', ar: 'خاص'}, {fr: 'Association', ar: 'جمعية'}],
                model: {
                    nom: '',

                    type_action: 'Particulier',
                    adresse: '',
                    gouvernorat: 'Ariana',
                    telephone: '',

                    type_don: 'Nourriture',
                    description: '',
                    motorise: false,
                    accord_utss: true,
                },
                acteurs: [],
                donId: null

            }
        },
        methods: {
            getName() {
                if (this.ar) {
                    if (this.model.type_action == 'Particulier') {
                        return ' الاسم واللقب';
                    } else {
                        return 'اسم الجمعية';
                    }
                } else {
                    if (this.model.type_action == 'Particulier') {
                        return 'Nom et prénom';
                    } else {
                        return 'Nom de l\'association';
                    }
                }
            },
            saveDon() {
                if (this.verifierFormulaire())
                    this.$store.dispatch('newDon', this.model)
                        .then(response => {
                            console.log(response);
                            this.acteurs = response.acteurs;
                            this.donId = response.don;
                            this.modals.choseActeur = true;
                            // this.modals.userModal = true;
                        })
            },
            choseUnActeur(acteur) {
                this.$store.dispatch('setActeur', {acteurId: acteur.id, donId: this.donId})
                    .then(response => {
                        console.log(response);
                        this.acteur = acteur;
                        this.modals.choseActeur = false;
                        this.modals.userModal = true;
                    })
            },
            verifierFormulaire() {
                let message = "Veuillez remplir tous les champs!"
                if (this.ar) {
                    message = 'يرجى إكمال جميع الحقول';
                }
                if (
                    this.model.nom == "" ||
                    this.model.description == "" ||
                    this.model.telephone == "" ||
                    this.model.adresse == ""
                ) {
                    this.$notify({
                        type: "danger",
                        timeout: 4000,
                        message: message,
                        icon: "tim-icons icon-bell-55",
                        horizontalAlign: "right",
                        verticalAlign: "top"
                    });
                    return false;
                }
                if (!this.checkPhone(this.model.telephone)) {
                    return false;
                }
                return true;
            },
            checkPhone(phone) {
                let message = "Numéro de téléphone invalide!"
                if (this.ar) {
                    message = 'رقم الهاتف غير صالح';
                }
                var strPhone = phone + "";
                console.log(strPhone.length);
                console.log(parseInt(strPhone[0]));
                if (
                    strPhone.length == 8 &&
                    (parseInt(strPhone[0]) == 2 ||
                        parseInt(strPhone[0]) == 4 ||
                        parseInt(strPhone[0]) == 5 ||
                        parseInt(strPhone[0]) == 9 ||
                        parseInt(strPhone[0]) == 7)
                ) {
                    return true;
                } else {
                    this.$notify({
                        type: "danger",
                        timeout: 4000,
                        message: message,
                        icon: "tim-icons icon-bell-55",
                        horizontalAlign: "right",
                        verticalAlign: "top"
                    });
                    return false;
                }
            },
        },
        computed: {
            gouvernorats() {
                return this.$store.getters.gouvernorats;
            },
            ar() {
                if (this.$route.query.ar)
                    return this.$route.query.ar
                return '';
            },
        }
    }
</script>
<style scoped>
    .content {
        padding: 82px;
    }

    .tim-icons .icon-single-02 {
        color: black !important;
    }

    .input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
        border-color: rgba(29, 37, 59, 0.5) !important;
    }
</style>
