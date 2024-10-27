import { expect, test } from '@wordpress/e2e-test-utils-playwright'

test.describe('Dashboard', () => {
  test.beforeEach(async ({ admin }) => {
    await admin.visitAdminPage('admin.php', 'page=fdg')
  })

  test('should be present', async ({ page }) => {
    expect(page.locator('#vue-app')).toBeVisible()
  })
})

test.describe('Gutenberg Editor', () => {
  test.beforeEach(async ({ admin }) => {
    await admin.createNewPost()
  })

  test('Heading block should be insertable', async ({ editor }) => {
    await editor.insertBlock({
      name: 'core/heading',
    })
    const block = (await editor.getBlocks())[0]
    expect(block.name).toBe('core/heading')
  })
})
