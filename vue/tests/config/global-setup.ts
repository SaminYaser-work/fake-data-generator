import { chromium } from '@playwright/test'

async function globalSetup() {
  const browser = await chromium.launch()
  const page = await browser.newPage()

  // Go to WordPress login
  await page.goto(`${process.env.WP_BASE_URL}/wp-login.php`)

  // Fill in login form
  await page.fill('#user_login', process.env.WP_USERNAME || 'admin')
  await page.fill('#user_pass', process.env.WP_PASSWORD || 'password')

  // Click login button and wait for navigation
  await Promise.all([
    page.click('#wp-submit'),
    page.waitForNavigation({ waitUntil: 'networkidle' }),
  ])

  // Wait for admin bar to ensure we're logged in
  await page.waitForSelector('#wpadminbar')

  // Save signed-in state to 'storage-state.json'
  await page.context().storageState({ path: './storage-state.json' })

  await browser.close()
}

export default globalSetup
