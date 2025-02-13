<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    discussions: Array
})

</script>
<template>
    <AuthenticatedLayout>
        <template #header>Discussions</template>
        <template #content>
            <ul >
                <li v-for="discussion in discussions" :key="discussion.id">
                       <span class="px-2 font-extrabold text-xl">
                            {{ discussion.created_by }}
                        </span>

                    <p class="text-right">
                        <span v-for="user in discussion.users" :key="user.id" class="px-2">
                            {{ user.full_name }}
                        </span>
                    </p>

                    <ul role="list" class="">
                    <li v-for="post in discussion.posts" :key="post.id" class="px-4 py-4 sm:px-0 border border-gray-100 rounded-md shadow-sm mt-2 mb-2">
                        <p class="p-4">{{ post.content }}</p>
                        <p class="p-4">{{ post.created_by }}</p>
                    </li>
                    </ul>

                </li>
            </ul>

        </template>
    </AuthenticatedLayout>
</template>
