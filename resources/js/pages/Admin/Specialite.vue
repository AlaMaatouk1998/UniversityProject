<template>
	<div class="content">
		<card>
			<template slot="header">
				<h4 class="title">Gérer les specialités</h4>
                <h2 class="title" v-if="etablissement">{{this.etablissementData.titre}}</h2>
				<div class="row filtre">
					<div class="col-xl-2">
						<base-input label="Filtrer par Diplome">
							<select
								class="form-control"
								@change="onFiltreDiplomeChange($event)"
                                v-model="filtres.diplome"
							>
                                <option value="" disabled selected>Rechercher par diplome</option>
								<option
									v-for="(diplome, index) in diplomes"
									:value="diplome.id"
									:key="index"
									>{{ diplome.titre }}</option
								>
							</select>
						</base-input>
                    </div>
                    <div class="col-xl-2">
						<base-input label="Filtrer par Mention">
							<select
								class="form-control "
								@change="onFiltreMentionChange($event)"
                                v-model="filtres.mention"
							>
                                <option value="" disabled selected>Rechercher par mention</option>
								<option
									v-for="(mention, index) in mentions"
									:value="mention.id"
									:key="index"
									>{{ mention.titre }}</option
								>
							</select>
						</base-input>
					</div>
					<div class="col-xl-2">
						<base-button
							style="    margin-top: 23px;"
							type="warning"
							fill
							v-on:click="onFiltreAll()"
							>Voir tous</base-button
						>
					</div>
					<div class="col-xl-2">
						<base-button
							style="    margin-top: 23px;"
							type="info"
                            v-if="etablissement"
							fill
							v-on:click="initAffectModal()"
							>Affecter specialité</base-button
						>
					</div>
					<div
						class="col-xl-4"
						v-if="parseInt(user.role) == 3"
					>
						<base-button
							style="   margin-top: 23px;"
							type="success"
							fill
							v-on:click="initSpecialiteModal()"
							>Ajouter une nouvelle specialité</base-button
						>
					</div>
				</div>
			</template>

			<!-- Affichage -->
			<div class="table-responsive">
				<table class="table tablesorter text-left">
					<thead class="text-primary">
						<tr>
							<slot nom="columns">
								<th>Titre (fr) </th>
								<th>Titre (ar)</th>
                                <th>Diplome</th>
                                <th>Mention</th>
                                <th>Domaine</th>
                                <th>Etablissements qui couvre cette specialite</th>
								<th>&nbsp;</th>
							</slot>
						</tr>
					</thead>
					<tbody>
						<tr v-if="loading">
							<td colspan="7">
								<div class="login text-center">
									<i class="tim-icons  icon-refresh-02 rotating"></i>
								</div>
							</td>
						</tr>
						<tr v-if="specialites.length == 0">
							<td colspan="7">
								<div class="login text-center">
									Aucune donnée trouvée...
								</div>
							</td>
						</tr>
						<tr v-for="(specialite, index) in specialites" :key="index">
							<td >{{ specialite.titre }}</td>
							<td>{{ specialite.titre_ar }}</td>
							<td>{{ specialite.diplome ? specialite.diplome.titre : '' }}</td>
							<td>{{ specialite.mention ? specialite.mention.titre : '' }}</td>
                            <td>{{ specialite.mention.domaine ? specialite.mention.domaine.titre : '' }}</td>
							<td>
								<base-button
									simple
									type="primary"
									v-on:click="selectSpecialite(specialite)"
									>Etablissements</base-button
								>
							</td>

							<td
								class="td-actions text-right"
                                style="min-width: 120px"
								v-if="parseInt(user.role) == 3"
							>
                                <base-button
                                   v-if="etablissement"
									type="warning"
									size="sm"
									icon
									v-on:click="desaffecterSpecialite(specialite.id)"
								>
									<i class="tim-icons icon-simple-delete"></i>
								</base-button>
								<base-button
									type="success"
									size="sm"
									icon
									v-on:click="editSpecialiteModal(specialite)"
								>
									<i class="tim-icons icon-settings"></i>
								</base-button>
								<base-button
									type="danger"
									size="sm"
									icon
									v-on:click="deleteSpecialite(specialite.id)"
								>
									<i class="tim-icons icon-simple-remove"></i>
								</base-button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<template slot="footer">
				
			</template>
		</card>

		<!-- Modal Affectation Specialite -->
        <modal :show.sync="modals.affectSpecialite">
            <template slot="header">
               Affecter une spécialité
            </template>
            <template>
                <base-input label="Spécialité">
                    <select
                        class="form-control "
                        v-model="affectedSpecialite.specialite_id"
                    >
                        <option
                            v-for="(specialite, index) in notAffectedSpecialite"
                            :value="specialite.id"
                            :key="index"
                            >{{ (specialite.diplome ? specialite.diplome.titre+' ' : '') + (specialite.mention ? specialite.mention.titre+' '  : '') + specialite.titre }}</option
                        >
                    </select>
                </base-input>
				<base-input
					label="Debut date d'habilitation :"
					v-model="affectedSpecialite.habilitation_start"
					type="text"
					placeholder="Debut date d'habilitation :"
				>
				</base-input>
				<base-input
					label="Fin date d'habilitation :"
					v-model="affectedSpecialite.habilitation_fin"
					type="text"
					placeholder="Fin date d'habilitation :"
				>
				</base-input>
				<base-input
					label="Code dossier : "
					v-model="affectedSpecialite.code_dossier"
					type="number"
					placeholder="Code dossier :"
				>
				</base-input>
            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.affectSpecialite = false;"
                    >Fermer</base-button
                >
				<base-button type="primary" @click="affectSpecialite">Affecter</base-button>
            </template>
        </modal>

		<!-- Modal Ajout/Modification Spéclaité -->
		<modal :show.sync="modals.specialite" class="text-left">
			<template slot="header">
				{{action == 'create' ? 'Ajouter' : 'Modifier' }}
			</template>

			<template>
				<base-input
					label="Titre : "
					v-model="specialiteModel.titre"
					type="text"
					placeholder="titre :"
				>
				</base-input>
				<base-input
					label="Titre arabe: "
					v-model="specialiteModel.titre_ar"
					type="text"
					placeholder="اسم الشعبة"
				>
				</base-input>
                <base-input label="Diplome">
                    <select
                        class="form-control "
                        v-model="specialiteModel.diplome_id"
                    >
                        <option
                            v-for="(diplome, index) in diplomes"
                            :value="diplome.id"
                            :key="index"
                            >{{ diplome.titre }}</option
                        >
                    </select>
                </base-input>
                <base-input label="Mention">
                    <select
                        class="form-control "
                        v-model="specialiteModel.mention_id"
                    >
                        <option
                            v-for="(mention, index) in mentions"
                            :value="mention.id"
                            :key="index"
                            >{{ mention.titre }}</option
                        >
                    </select>
                </base-input>
			</template>
			<template slot="footer">
				<base-button type="secondary" @click="modals.specialite = false"
					>Annuler</base-button
				>
				<base-button type="primary" @click="actionSpecialite">{{action == 'create' ? 'Ajouter' : 'Modifier' }}</base-button>
			</template>
		</modal>
	</div>
</template>
<script>
import { Card, BaseInput } from "../../components/index";

import BaseButton from "../../components/BaseButton";
import BaseTable from "../../components/BaseTable";
import { Modal } from "../../components/index";
export default {
	components: {
		Card,
		BaseInput,
		BaseButton,
		BaseTable,
		Modal
	},
	data() {
		return {
			modals: {
				detailsModal: false,
				specialite: false,
				affectSpecialite: false 
			},
			loading: true,
			specialiteModel: {},
			action: "create",
            selectedSpecialite: {},
            filtres: {
                diplome: '',
                mention: ''
            },
            context: false,
            affectedSpecialite: {habilitation_start: null},
            notAffectedSpecialite: [],
            etablissementData: {}
		};
	},
	methods: {
        selectSpecialite(specialite){
            this.selectedSpecialite = specialite;
            this.modals.detailsModal = true;
        },
        initSpecialiteModal(){
            this.action = 'create';
            this.specialiteModel = {};
            this.modals.specialite = true;
        },
        editSpecialiteModal(specialite){
            this.action = 'update';
            this.specialiteModel = specialite;
            this.modals.specialite = true;
        },
		actionSpecialite() {
            // validation

			if (this.action == "create") {
				this.$store
					.dispatch("createSpecialite", {specialite: this.specialiteModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "success",
							timeout: 4000,
							message: "Nouvelle specialite crée!"
						});
						this.modals.specialite = false;
					});
			} else if (this.action == "update") {
				this.$store
					.dispatch("updateSpecialite", {specialite: this.specialiteModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "primary",
							timeout: 4000,
							message: "Specialite modifiée!"
						});
						this.modals.specialite = false;
					});
			}
		},
		deleteSpecialite(selectedSpecialite) {
            this.$dialog
            .confirm('Etes-vous sûre de supprimer ce specialite ?', {cancelText: 'Non', okText: 'Oui', customClass:'modal-danger'})
            .then((dialog) => {
			this.$store
				.dispatch("deleteSpecialite", selectedSpecialite)
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "Specialite supprimée!"
					});
				});
            })
            .catch(() => {
            });
        },
        initAffectModal(){
            this.modals.affectSpecialite = true;
            this.$store.dispatch("getNotAffectedSpecialites", "not_affected="+this.etablissement).then(response => {
                this.notAffectedSpecialite = response
            });
            this.affectedSpecialite = {};
        },
		affectSpecialite() {
            if(this.etablissement && this.affectedSpecialite.specialite_id){
                this.$store
                    .dispatch("affectSpecialite", { 
							specialite_id: this.affectedSpecialite.specialite_id,
							habilitation_debut: this.affectedSpecialite.habilitation_start,
							etablissement_id: this.etablissement,
							habilitation_fin: this.affectedSpecialite.habilitation_fin,
							code_dossier: this.affectedSpecialite.code_dossier,
                     })
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "success",
							timeout: 4000,
							message: "Spécialité affectée"
						});
                        this.modals.affectSpecialite = false;
                        this.$store.dispatch("getSpecialites", "").then(response => {
                            this.loading = false;
                        });
                 });
            }
        },
        desaffecterSpecialite(selectedSpecialite) {
            this.$dialog
            .confirm('Etes-vous sûre de désaffecter cette specialite ?', {cancelText: 'Non', okText: 'Oui', customClass:'modal-danger'})
            .then((dialog) => {
			this.$store
				.dispatch("desaffecterSpecialite", {etablissement_id: this.etablissement, specialite_id: selectedSpecialite})
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "Specialite désaffectée!"
                    });
                this.$store.dispatch("getSpecialites", "").then(response => {
                    this.loading = false;
                });
				});
            })
            .catch(() => {
            });
        },        
        onFiltreMentionChange(event){
            this.filtre();
        },
        onFiltreDiplomeChange(event){
            this.filtre();
        },
        filtre(){
            let filtre = '';
            if(this.filtres.diplome != '')
                    filtre += 'diplome='+this.filtres.diplome+'&';
            if(this.filtres.mention != '')
                    filtre += 'mention='+this.filtres.mention+'&';
            if(filtre != '')
            this.$store.dispatch("getSpecialites", filtre).then(response => {
                    this.loading = false;
                });  
        },
        onFiltreAll(){
            this.filtres = {
                diplome: '',
                mention: ''
            };
            this.$store.dispatch("getSpecialites", "").then(response => {
                this.loading = false;
            });
        }
	},
	created() {
		// this.$store.dispatch("getSpecialites", "").then(response => {
		// 	this.loading = false;
		// });
    },
    mounted(){
        if(this.etablissement){
            this.$store.commit('setContext','etablissement='+this.etablissement)
            this.$store.dispatch('getEtablissementData', this.etablissement).then((response)=>{
                this.etablissementData = response;
            })
        }else{
            this.$store.commit('setContext', null);
        }
        this.$store.dispatch("getSpecialites", "").then(response => {
			this.loading = false;
		});
    },
	computed: {
		user() {
			return this.$store.getters.user;
		},
		specialites() {
			return this.$store.getters.specialites;
		},
		domaines() {
			return this.$store.getters.domaines;
        },
		diplomes() {
			return this.$store.getters.diplomes;
        },
		mentions() {
			return this.$store.getters.mentions;
        },
		gouvernorats() {
			return this.$store.getters.gouvernorats;
        },
        etablissement(){
            if (this.$route.query.etablissement)
                 return this.$route.query.etablissement;
            return null;
        }
	}
};
</script>
