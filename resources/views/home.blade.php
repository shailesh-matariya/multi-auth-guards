@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>

            <div class="row mt-4"></div>
            <div class="card">
                <div class="card-header">Users list</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users">
                            <th scope="row">@{{ user.id }}</th>
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.email }}</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="navigation">
                        <pagination ref="pagination" :paginate="10" :apiUrl="apiUrl"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer-scripts')
    <script>
        Vue.component('pagination', {
            template: `<div class="prov-page" v-if="pagination.total > paginate">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li class="page-item" v-if="pagination.current_page > 1"><a class="page-link" href="javascript:void(0);" aria-label="First" @click="goFirst()">First</a></li>
        <li class="page-item" v-if="pagination.current_page > 1"><a class="page-link" href="javascript:void(0);" aria-label="Previous" @click="goPrev()">@{{ pagination.current_page - 1 }}</a></li>
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">@{{ pagination.current_page }}</a></li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page"><a class="page-link" href="javascript:void(0);" aria-label="Next" @click="goNext()">@{{ pagination.current_page + 1 }}</a></li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page"><a class="page-link" href="javascript:void(0);" aria-label="Last" @click="goLast()">Last</a></li>
      </ul>
    </nav>
  </div>`,
            props: ['apiUrl', 'paginate'],

            data() {
                return {
                    pagination: {}
                }
            },

            methods: {
                goFirst() {
                    this.$parent.apiUrl = this.pagination.first_page_url
                    this.$parent.makeApiCall()
                },

                goLast() {
                    this.$parent.apiUrl = this.pagination.last_page_url
                    this.$parent.makeApiCall()
                },

                goPrev() {
                    this.$parent.apiUrl = this.pagination.prev_page_url
                    this.$parent.makeApiCall()
                },

                goNext() {
                    this.$parent.apiUrl = this.pagination.next_page_url
                    this.$parent.makeApiCall()
                },

                makePagination(data) {
                    this.$data.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        prev_page_url: data.prev_page_url,
                        next_page_url: data.next_page_url,
                        first_page_url: data.first_page_url,
                        last_page_url: data.last_page_url,
                        total: data.total,
                        per_page: data.per_page
                    }
                },
            }
        });

        const app = new Vue({
            el: '#app',
            data: {
                apiUrl: '',
                users: [],
                parameters: {
                    search: ""
                },
            },
            components: {

            },
            mounted() {
                this.initializeCategory();
            },
            methods: {
                getUsers() {
                    axios.post(this.apiUrl, this.parameters)
                        .then(response => {
                            if (response.status == 200) {
                                this.users = response.data.users.data;

                                this.$refs.pagination.makePagination(response.data.users);
                            }
                        })
                        .catch(errors => {
                            console.log(errors)
                        })
                },

                initializeCategory() {
                    this.apiUrl = "{{ route('app1.getUsersAjax') }}";
                    this.makeApiCall();
                },

                makeApiCall() {
                    this.getUsers();
                }
            }
        });
    </script>
@endsection
