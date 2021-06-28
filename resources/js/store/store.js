
import Axios from "axios";
export default {
    state: {
     token : localStorage.getItem('access_token_jesr') || null,
     user: localStorage.getItem('user_jesr') || null,
     universites: [],
     etablissements: [],
     diplomes: [],
     mentions: [],
     specialites: [],
     domaines: [],
     apiurl:'',
     all_universites:[],
     context: null,
     refresh: false,
     gouvernorats: [  {fr :"Ariana", ar: 'أريانة'},
     {fr :"Beja", ar: 'باجة'},
     {fr :"Ben Arous", ar: 'بن عروس'},
     {fr :"Bizerte", ar: 'بنزرت'},
     {fr :"Gabes", ar: 'قابس'},
     {fr :"Gafsa", ar: 'قفصة'},
     {fr :"Jendouba", ar: 'جندوبة'},
     {fr :"Kairouan", ar: 'القيروان'},
     {fr :"Kasserine", ar: 'القصرين'},
     {fr :"Kebili", ar: 'قبلي'},
     {fr :"Le Kef", ar: 'الكاف'},
     {fr :"Mahdia", ar: 'المهدية'},
     {fr :"La Manouba", ar: 'منوبة'},
     {fr :"Medenine", ar: 'مدنين'},
     {fr :"Monastir", ar: 'المنستير'},
     {fr :"Nabeul", ar: 'نابل'},
     {fr :"Sfax", ar: 'صفاقس'},
     {fr :"Sidi Bouzid", ar: 'سيدي بوزيد'},
     {fr :"Siliana", ar: 'سليانة'},
     {fr :"Sousse", ar: 'سوسة'},
     {fr :"Tataouine", ar: 'تطاوين'},
     {fr :"Tozeur", ar: 'توزر'},
     {fr :"Tunis", ar: 'تونس'},
     {fr :"Zaghouan",  ar: 'زغوان'},],
    },

    getters: {
        loggedIn(state){
            return state.token != null;
        },
        user(state){
            if(!state.user) {
                return {};
            }
            return JSON.parse(state.user);
        },
        apiurl(state){
            return state.apiurl;
        },
        refresh(state){
            return state.refresh;
        },
        universites(state){
            return state.universites;
        },
        etablissements(state){
            return state.etablissements;
        },
        diplomes(state){
            return state.diplomes;
        },
        mentions(state){
            return state.mentions;
        },
        specialites(state){
            return state.specialites;
        },
        domaines(state){
            return state.domaines;
        },
        gouvernorats(state) {
            return state.gouvernorats;
        },
        all_universites(state){
            return state.all_universites;
        },
        context(state) {
            if(state.context)
                return '?'+state.context+'&';
            return '?';
        }
    },
    mutations: {
        setUser(sate, user){
            sate.user = user;
        },
        retrieveToken(state, token){
            state.token = token;
        },
        destroyToken(state){
            state.token = null;
        },
        toggleRefresh(state, refresh){
            state.refresh = refresh;
        },
        setUniversites(state, universites){
            state.universites = universites;
        },
        setEtablissements(state, etablissements){
            state.etablissements = etablissements;
        },
        setDiplomes(state, diplomes){
            state.diplomes = diplomes;
        },
        setDomaines(state, domaines){
            state.domaines = domaines;
        },
        setMentions(state, mentions){
            state.mentions = mentions;
        },
        setSpecialites(state, specialites){
            state.specialites = specialites;
        },
        setContext(state, context){
            state.context = context;
        },
        setAllUniversites(state, universites){
            state.all_universites = universites;
        }

    },
    actions: {
        retrieveUser(context){
            if(!context.getters.user){
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                return new Promise((resolve, reject) => {
                    Axios.get(context.state.apiurl+'/api/user')
                    .then(response => {
                        localStorage.setItem('user', JSON.stringify(response.data));
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error);
                    })
              })
            }
        },
        retrieveToken(context, credentials){
            return new Promise((resolve, reject) => {
                Axios.post(context.state.apiurl+'/api/login',{
                    username : credentials.username,
                    password: credentials.password
                })
                .then(response => {
                    const token = response.data.access_token;
                    localStorage.setItem('access_token_jesr', token);
                    context.commit('retrieveToken', token);
                        Axios.defaults.headers.common['Authorization'] = 'Bearer '+ token;
                        Axios.get(context.state.apiurl+'/api/user')
                        .then(response => {
                            localStorage.setItem('user_jesr', JSON.stringify(response.data));
                            context.commit('setUser', JSON.stringify(response.data));
                            resolve(response.data);
                        })
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        destroyToken(context){
            if(context.getters.loggedIn){ 
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                return new Promise((resolve, reject) => {
                    Axios.post(context.state.apiurl+'/api/logout')
                    .then(response => {
                        localStorage.removeItem('access_token_jesr');
                        context.commit('destroyToken');
                        resolve(response);
                        
                    })
                    .catch(error => {
                        localStorage.removeItem('access_token_jesr');
                        context.commit('destroyToken');
                        reject(error);
                    })
                })
            }
        },
        register(context, data){
            return new Promise((resolve, reject) => {
                Axios.post(context.state.apiurl+'/api/register',{
                    name : data.name,
                    email: data.email,
                    password: data.password
                })
                .then(response => {
                    resolve(response);
                    
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        newUser(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/register', data)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getUsers');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        updateUser(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/users/'+data.userId, data.user)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteUser(context, userId){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/users/'+ userId)
                .then(response => {
                    context.commit('toggleRefresh', false);
                    context.dispatch('getUsers');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getUsers(context){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/users')
                .then(response => {
                    
                    context.commit('setfiltredUsers', JSON.stringify(response.data));
                    context.commit('setUsers', JSON.stringify(response.data));
                    context.commit('toggleRefresh', true);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        updatePassword(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/updatePassword/'+data.userId, {
                    password: data.password
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },   
        //----------CRUD Universite
        createUniversite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/universites', data)
                .then(response => {
                    context.dispatch('getUniversites');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },   
        getUniversites(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/universites?'+filtre)
                .then(response => {
                    context.commit('setUniversites', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getAllUniversites(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/universites?'+filtre)
                .then(response => {
                    context.commit('setAllUniversites', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteUniversite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/universites/'+data)
                .then(response => {
                    context.dispatch('getUniversites');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        updateUniversite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/universites/'+data.universite.id, data)
                .then(response => {
                    context.dispatch('getUniversites');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        //----------CRUD Etablissement 
        createEtablissement(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/etablissements', data)
                .then(response => {
                    context.dispatch('getEtablissements');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },   
        getEtablissements(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/etablissements?'+filtre)
                .then(response => {
                    context.commit('setEtablissements', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getEtablissementData(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/etablissements/'+data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteEtablissement(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/etablissements/'+data)
                .then(response => {
                    context.dispatch('getEtablissements');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        updateEtablissement(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/etablissements/'+data.etablissement.id, data)
                .then(response => {
                    context.dispatch('getEtablissements');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        affectSpecialite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/etablissements/affect/specialite/'+data.etablissement_id, data)
                .then(response => {
                    // context.dispatch('getEtablissements');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        desaffecterSpecialite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/etablissements/desaffect/specialite/'+data.etablissement_id, data)
                .then(response => {
                    // context.dispatch('getEtablissements');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        
        //------------CRUD DOMAINES
        createDomaine(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/domaines', data)
                .then(response => {
                    context.dispatch('getDomaines');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },   
        getDomaines(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/domaines?'+filtre)
                .then(response => {
                    context.commit('setDomaines', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteDomaine(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/domaines/'+data)
                .then(response => {
                    context.dispatch('getDomaines');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        updateDomaine(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/domaines/'+data.domaine.id, data)
                .then(response => {
                    context.dispatch('getDomaines');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        //---------CRUD Mentions:
        createMention(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/mentions', data)
                .then(response => {
                    context.dispatch('getMentions');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },   
        getMentions(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/mentions?'+filtre)
                .then(response => {
                    context.commit('setMentions', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteMention(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/mentions/'+data)
                .then(response => {
                    context.dispatch('getMentions');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        updateMention(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/mentions/'+data.mention.id, data)
                .then(response => {
                    context.dispatch('getMentions');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        createSpecialite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/specialites', data)
                .then(response => {
                    context.dispatch('getSpecialites');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },   
        getSpecialites(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/specialites'+context.getters.context + filtre)
                .then(response => {
                    context.commit('setSpecialites', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        getNotAffectedSpecialites(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/specialites?'+filtre)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteSpecialite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/specialites/'+data)
                .then(response => {
                    context.dispatch('getSpecialites');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        updateSpecialite(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/specialites/'+data.specialite.id, data)
                .then(response => {
                    context.dispatch('getSpecialites');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        //-------CRUD DIPLOMES
        createDiplome(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/diplomes', data)
                .then(response => {
                    context.dispatch('getDiplomes');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },   
        getDiplomes(context, filtre){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.get(context.state.apiurl+'/api/diplomes?'+filtre)
                .then(response => {
                    context.commit('setDiplomes', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        deleteDiplome(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.delete(context.state.apiurl+'/api/diplomes/'+data)
                .then(response => {
                    context.dispatch('getDiplomes');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        updateDiplome(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.put(context.state.apiurl+'/api/diplomes/'+data.diplome.id, data)
                .then(response => {
                    context.dispatch('getDiplomes');
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        generatePDF(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/generatePDF',
                data,
                   {responseType: 'blob'}
                )
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'etablissements.pdf');
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    reject(error);
                })
            })
        }, 
        generateExcel(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/generateExcel',
                data,
                   {responseType: 'blob'}
                )
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'etablissements.xlsx');
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        generateCSV(context, data){
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common['Authorization'] = 'Bearer '+ context.state.token;
                Axios.post(context.state.apiurl+'/api/generateCSV',
                data,
                   {responseType: 'blob'}
                )
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'etablissements.csv');
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
    }
};