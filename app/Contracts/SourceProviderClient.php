<?php

namespace App\Contracts;

use App\Models\Deployment;
use App\Models\Hook;
use App\Models\Stack;

interface SourceProviderClient
{
    /**
     * Determine if the source control credentials are valid.
     *
     * @return bool
     */
    public function valid();

    /**
     * Validate the given repository and branch are valid.
     *
     * @param  string  $repository
     * @param  string  $branch
     * @return bool
     */
    public function validRepository($repository, $branch);

    /**
     * Validate the given repository and commit hash are valid.
     *
     * @param  string  $repository
     * @param  string  $hash
     * @return bool
     */
    public function validCommit($repository, $hash);

    /**
     * Get the latest commit hash for the given repository and branch.
     *
     * @param  string  $repository
     * @param  string  $branch
     * @return string
     */
    public function latestHashFor($repository, $branch);

    /**
     * Get the tarball URL for the given deployment.
     *
     * @param  \App\Models\Deployment $deployment
     *
     * @return string
     */
    public function tarballUrl(Deployment $deployment);

    /**
     * Publish the given hook.
     *
     * @param  \App\Models\Hook $hook
     *
     * @return void
     */
    public function publishHook(Hook $hook);

    /**
     * Determine if the given hook payload is a test.
     *
     * @param \App\Models\Hook $hook
     * @param  array           $payload
     *
     * @return bool
     */
    public function isTestHookPayload(Hook $hook, array $payload);

    /**
     * Determine if the given hook payload applies to the hook.
     *
     * @param \App\Models\Hook $hook
     * @param  array           $payload
     *
     * @return bool
     */
    public function receivesHookPayload(Hook $hook, array $payload);

    /**
     * Get the commit hash from the given hook payload.
     *
     * @param  array  $payload
     * @return string
     */
    public function extractCommitFromHookPayload(array $payload);

    /**
     * Unpublish the given hook.
     *
     * @param  \App\Models\Hook $hook
     *
     * @return void
     */
    public function unpublishHook(Hook $hook);

    /**
     * Get the manifest content for the given stack and hash.
     *
     * @param  \App\Models\Stack $stack
     * @param  string            $repository
     * @param  string            $hash
     *
     * @return string
     */
    public function manifest(Stack $stack, $repository, $hash);
}
