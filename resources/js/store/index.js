//
// import {createStore} from "vuex";
// import user from './user.js'
// import product from './product.js'
//
// export default createStore({
//     modules: {
//         product,
// },
//     state: {
//         user: null,
//     },
//     mutations: {
//         setUser(state, user) {
//             state.user = user;
//         }
//     },
//     actions: {
//         async getUser({ commit }){
//             if (localStorage.getItem('token')) {
//                 try {
//                     const response = await axios.get('/user', {
//                         headers: {
//                             Authorization: 'Bearer ' + localStorage.getItem('token')
//                         }
//                     });
//                     commit('setUser', response.data);
//                 } catch (error) {
//                     console.error('Error setting user:', error);
//                 }
//             }
//         }
//     },
//     getters: {
//         user: state => state.user,
//     }
// });
