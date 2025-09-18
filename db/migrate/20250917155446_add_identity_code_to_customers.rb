class AddIdentityCodeToCustomers < ActiveRecord::Migration[8.0]
  def change
    add_column :customers, :identity_code, :string
  end
end
