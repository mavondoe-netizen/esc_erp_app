<?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>

    <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        <?= $this->Form->button(__('Sign In'), ['class' => 'btn btn-primary', 'style' => 'width: 100%; justify-content: center;']) ?>
        <div style="text-align: center; color: var(--color-text-muted); font-size: 0.875rem;">
            Don't have an account? <?= $this->Html->link('Create one', ['action' => 'register'], ['style' => 'font-weight: 500;']) ?>
        </div>
    </div>
<?= $this->Form->end() ?>
