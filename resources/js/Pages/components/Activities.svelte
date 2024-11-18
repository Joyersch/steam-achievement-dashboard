<script>
    export let data;
    let lastDate = null;

    function isNewDay(date) {
        if (lastDate !== date) {
            lastDate = date;
            return true;
        }
        return false;
    }
</script>

<div class="container">
    {#each data.activities as activity}
        {#if isNewDay(activity.date)}
            <div class="ml-1 text-2xl mt-2 mb-1">
                {activity.date}
            </div>
        {/if}
        <div class="text-xl">
            <div class="ml-3 mr-3">
                <p>
                    -
                    {#if activity.type === "AchievementGained"}
                        <a href="stats/{activity.user.name}">
                            <strong style="color:{activity.user.color}">
                                {activity.user.name}
                            </strong>
                        </a>
                        <span class="text-user_gained">gained</span>
                        achievements in
                        <a href="stats/{activity.user.name}/{activity.game.id}">
                            <strong>
                                {activity.game.name}
                            </strong>
                        </a>
                    {/if}
                    {#if activity.type === "AchievementLost"}
                        <a href="stats/{activity.user.name}">
                            <strong style="color:{activity.user.color}">
                                {activity.user.name}
                            </strong>
                        </a>
                        <span class="text-user_lost">lost</span>
                        achievements in
                        <strong>
                            {activity.game.name}
                        </strong>
                    {/if}
                    {#if activity.type === "GameAchievementAdded"}
                        Achievements
                        <span class="text-game_added">added</span>
                        to
                        <strong>
                            {activity.game.name}
                        </strong>
                    {/if}
                    {#if activity.type === "GameAchievementRemoved"}
                        Achievements
                        <span class="text-game_removed">removed</span>
                        from
                        <strong>
                            {activity.game.name}
                        </strong>
                    {/if}
                </p>
            </div>
        </div>
    {/each}
</div>
