// import productService from "../services/productService.js";
//
// export default {
//     namespaced: true,
//     state: () => ({
//         products: [],
//         // user: null,
//     }),
//     mutations: {
//         setProducts(state, products) {
//             state.products = products;
//         },
//         // setUser(state, user) {
//         //     state.user = user;
//         // }
//     },
//     action: {
//         async getProducts({ commit }){
//             try {
//                 const response = await productService.getProducts();
//                 commit('setProducts', response.data);
//             } catch (error) {
//                 console.error('Error set products:', error)
//             }
//         },
//
//     },
//     getters: {
//         products: state => state.products,
//     }
// }
