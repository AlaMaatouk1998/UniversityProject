<template>
	<div class="content">
		<card>
			<template slot="header">
				<h5 class="title">Gérer les domaines</h5>
				<div class="row filtre">
					<!-- <div class="col-xl-4">
						<base-input label="Filtrer par gouvernorat">
							<select
								class="form-control "
								@change="onFiltreGouvernoratChange($event)"
                                v-model="filtres.gouvernorat"
							>
                                <option value="" disabled selected>Rechercher par gouvernorat</option>
								<option
									v-for="(gouvernorat, index) in gouvernorats"
									:value="gouvernorat.fr"
									:key="index"
									>{{ gouvernorat.fr }}</option
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
					</div> -->
					<div
						class="col-xl-3"
						v-if="parseInt(user.role) == 3"
					>
						<base-button
							style="   margin-top: 23px;"
							type="success"
							fill
							v-on:click="initDomaineModal()"
							>Ajouter un nouveau domaine</base-button
						>
					</div>
				</div>
			</template>
			<div class="table-responsive">
				<table class="table tablesorter text-left">
					<thead class="text-primary">
						<tr>
							<slot nom="columns">
								<th>Titre (fr) </th>
								<th>Titre (ar)</th>
                                <th>Etablissements qui couvre ce domaine</th>
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
						<tr v-if="domaines.length == 0">
							<td colspan="7">
								<div class="login text-center">
									Aucune donnée trouvée...
								</div>
							</td>
						</tr>
						<tr v-for="(domaine, index) in domaines" :key="index">
							<td>{{ domaine.titre }}</td>
							<td>{{ domaine.titre_ar }}</td>
							<td>
								<base-button
									simple
									type="primary"
									v-on:click="selectDomaine(domaine)"
									>Etablissements</base-button
								>
							</td>

							<td
								class="td-actions text-right"
								v-if="parseInt(user.role) == 3"
							>
								<base-button
									type="success"
									size="sm"
									icon
									v-on:click="editDomaineModal(domaine)"
								>
									<i class="tim-icons icon-settings"></i>
								</base-button>
								<base-button
									type="danger"
									size="sm"
									icon
									v-on:click="deleteDomaine(domaine.id)"
								>
									<i class="tim-icons icon-simple-remove"></i>
								</base-button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<template slot="footer">
				<!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
			</template>
		</card>
        <modal :show.sync="modals.detailsModal">
            <template slot="header">
                Demandé par
            </template>
            <template>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Prentation:</span>
                    {{this.selectedDomaine.presentation}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Telephone:</span>
                    {{this.selectedDomaine.telephone}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Fax:</span>
                    {{this.selectedDomaine.fax}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Lien:</span>
                    {{this.selectedDomaine.url}}&nbsp;
                </p>
                </div> 

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.detailsModal = false;"
                    >Fermer</base-button
                >
            </template>
        </modal>
		<modal :show.sync="modals.domaine" class="text-left">
			<template slot="header">
				{{action == 'create' ? 'Ajouter' : 'Modifier' }}
			</template>

			<template>
				<base-input
					label="Titre : "
					v-model="domaineModel.titre"
					type="text"
					placeholder="titre :"
				>
				</base-input>
				<base-input
					label="Titre arabe: "
					v-model="domaineModel.titre_ar"
					type="text"
					placeholder="اسم المجال"
				>
				</base-input>
			</template>
			<template slot="footer">
				<base-button type="secondary" @click="modals.domaine = false"
					>Annuler</base-button
				>
				<base-button type="primary" @click="actionDomaine">{{action == 'create' ? 'Ajouter' : 'Modifier' }}</base-button>
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
				domaine: false,
				deleteDomaine: false
			},
			loading: true,
			domaineModel: {},
			action: "create",
            selectedDomaine: {},
            filtres: {
                gouvernorat: ''
            }
		};
	},
	methods: {
        selectDomaine(domaine){
            this.selectedDomaine = domaine;
            this.modals.detailsModal = true;
        },
        initDomaineModal(){
            this.action = 'create';
            this.domaineModel = {};
            this.modals.domaine = true;
        },
        editDomaineModal(domaine){
            this.action = 'update';
            this.domaineModel = domaine;
            this.modals.domaine = true;
        },
		actionDomaine() {
            // validation

			if (this.action == "create") {
				this.$store
					.dispatch("createDomaine", {domaine: this.domaineModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "success",
							timeout: 4000,
							message: "Nouveau domaine crée!"
						});
						this.modals.domaine = false;
					});
			} else if (this.action == "update") {
				this.$store
					.dispatch("updateDomaine", {domaine: this.domaineModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "primary",
							timeout: 4000,
							message: "Domaine modifié!"
						});
						this.modals.domaine = false;
					});
			}
		},
		deleteDomaine(selectedDomaine) {
            this.$dialog
            .confirm('Etes-vous sûre de supprimer ce domaine ?', {cancelText: 'Non', okText: 'Oui', customClass:'modal-danger'})
            .then((dialog) => {
			this.$store
				.dispatch("deleteDomaine", selectedDomaine)
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "Domaine supprimée!"
					});
				});
            })
            .catch(() => {
            });
        },
        onFiltreGouvernoratChange(event){
            this.$store.dispatch("getDomaines", 'gouvernorat='+event.target.value).then(response => {
                this.loading = false;
            });
        },
        onFiltreAll(){
            this.filtres.gouvernorat = '';
            this.$store.dispatch("getDomaines", "").then(response => {
                this.loading = false;
            });
        }
	},
	created() {
		this.$store.dispatch("getDomaines", "").then(response => {
			this.loading = false;
		});
	},
	computed: {
		user() {
			return this.$store.getters.user;
		},
		domaines() {
			return this.$store.getters.domaines;
		},
		gouvernorats() {
			return this.$store.getters.gouvernorats;
		}
	}
};
</script>
