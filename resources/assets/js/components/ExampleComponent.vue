<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                    <div>
                        <v-btn color="success">Success</v-btn>
                        <v-btn color="error">Error</v-btn>
                        <v-btn color="warning">Warning</v-btn>
                        <v-btn color="info">Info</v-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
