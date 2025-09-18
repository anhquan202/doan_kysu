class DropCustomerContract < ActiveRecord::Migration[8.0]
  def change
    drop_table :contract_customers
  end
end
