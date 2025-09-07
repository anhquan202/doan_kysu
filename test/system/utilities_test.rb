require "application_system_test_case"

class UtilitiesTest < ApplicationSystemTestCase
  setup do
    @utility = utilities(:one)
  end

  test "visiting the index" do
    visit utilities_url
    assert_selector "h1", text: "Utilities"
  end

  test "should create utility" do
    visit utilities_url
    click_on "New utility"

    fill_in "Fee", with: @utility.fee
    fill_in "Type", with: @utility.type
    fill_in "Unit", with: @utility.unit
    click_on "Create Utility"

    assert_text "Utility was successfully created"
    click_on "Back"
  end

  test "should update Utility" do
    visit utility_url(@utility)
    click_on "Edit this utility", match: :first

    fill_in "Fee", with: @utility.fee
    fill_in "Type", with: @utility.type
    fill_in "Unit", with: @utility.unit
    click_on "Update Utility"

    assert_text "Utility was successfully updated"
    click_on "Back"
  end

  test "should destroy Utility" do
    visit utility_url(@utility)
    click_on "Destroy this utility", match: :first

    assert_text "Utility was successfully destroyed"
  end
end
