# Issue tracker: GitHub

https://github.com/lipemat/phpstan-wordpress/issues

Tickets and plans for this repo live as GitHub issues. Use the `gh` CLI for all operations; it infers the repo from `git remote -v` when run inside a clone.

## Lifecycle

Every issue and ticket carries exactly one lifecycle state, applied as a label of the same name:

| State | Meaning | Set by |
| --- | --- | --- |
| `ready` | Available to pick up. | `plan-save`, `plan-to-tickets` |
| `in-progress` | Being implemented right now. | `plan-implement` |
| `pending-qa` | Ready for qa. Not a blocker. | `plan-implement` |

Moving an item to a state means removing the state label it currently holds and adding the new one.

`pending-qa` is terminal for the skills. Release is manual, so no skill closes an issue or moves it past this state; closing after release is the human's call.

## Conventions

- Use the `gh issue` commands for all operations (create, view, list, edit, comment, close, labels, `--parent` for sub-issues).

## When a skill says "publish to the issue tracker"

Create a GitHub issue.

## When a skill says "link the branch to the issue"

GitHub's API can only link a branch while creating it (`createLinkedBranch`), so create the remote branch through the issue: `gh issue develop <number> --name <branch> --base <default-branch>`. The local branch of the same name then pushes onto it.

## When a skill says "fetch the relevant ticket"

Run `gh issue view <number>`. When the ticket is a sub-issue, fetch its parent the same way.

## GitHub Project

Issue status is managed in GitHub project **16** (owner `lipemat`), in its `Status` field. Any time an issue's lifecycle state changes, update both its label and its status in the project.

Each lifecycle state maps to one status option:

| Lifecycle state | Project status |
| --- | --- |
| `ready` | Ready |
| `in-progress` | In progress |
| `pending-qa` | Pending QA |

The project's other statuses (`Backlog`, `Pending release`, `Done`) are managed by hand; no skill sets them.

### Updating the status of an issue

```bash
gh project item-edit 16 --owner lipemat --url <issue url> --field Status --value "<project status>"
```

Success prints nothing and exits 0; trust it, no need to re-check. Any failure prints an error and exits 1. An issue not yet in the project fails; add it with `gh project item-add` and retry.
