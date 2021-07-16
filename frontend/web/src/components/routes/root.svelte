<script lang="ts">
	import {user} from "src/services/stores";
	import route from "src/services/route";
	if($user) route.submission.list();
	else route.auth.signIn();
</script>